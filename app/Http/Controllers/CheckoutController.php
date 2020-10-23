<?php


namespace App\Http\Controllers;

use App\Http\Requests\Checkout\StoreFormRequest;
use App\Models\Customer;
use App\Models\NPDepartment;
use App\Models\Order;
use App\Services\CustomerService;
use App\Services\NPDepartmentService;
use App\Services\OrderService;
use App\Services\StripeOrderService;
use App\Services\StripeTokenService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Stripe\Exception\ApiErrorException;
use Stripe;


class CheckoutController extends Controller
{
    /** @var CustomerService */
    protected $customerService;

    /** @var NPDepartmentService */
    protected $departmentService;

    /** @var StripeOrderService */
    protected $stripeOrderService;

    /** @var OrderService */
    protected $orderService;

    /** @var StripeTokenService */
    protected $stripeTokenService;

    /**
     * CheckoutController constructor.
     *
     * @param CustomerService $customerService
     * @param NPDepartmentService $departmentService
     * @param StripeOrderService $stripeOrderService
     * @param OrderService $orderService
     * @param StripeTokenService $stripeTokenService
     */
    public function __construct(
                                CustomerService $customerService,
                                NPDepartmentService $departmentService,
                                StripeOrderService $stripeOrderService,
                                OrderService $orderService,
                                StripeTokenService $stripeTokenService
    )
    {
        $this->customerService = $customerService;
        $this->departmentService = $departmentService;
        $this->stripeOrderService = $stripeOrderService;
        $this->orderService = $orderService;
        $this->stripeTokenService = $stripeTokenService;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('checkout');
    }

    public function store(StoreFormRequest $request)
    {
        if (!$request->session()->get('cart') || empty($request->session()->get('cart')))
        {
            return redirect()->route('checkout')->with(['message' => 'No products in cart']);
        }

        $amount = $request->session()->get('price');

        DB::beginTransaction();

        /** @var Customer $customer */
        $customer = $this->customerService->create($request->first_name, $request->last_name, $request->email, $request->mobile_phone);

        /** @var NPDepartment $department */
        $department = $this->departmentService->create($customer, $request->city, $request->np_json);

        try {
            /** @var Stripe\Order $stripeOrder */
            $stripeOrder = $this->stripeOrderService->create($customer, $amount);

            /** @var Order $order */
            $order = $this->orderService->create($customer, $department, $stripeOrder);

            $this->orderService->addProductsInOrder($order, $request->session()->get('cart'));

            /** @var string $token */
            $token = $this->stripeTokenService->getToken($request->getCard());

            /** @var Stripe\Order $stripeOrder */
            $stripeOrder = $this->stripeOrderService->pay($order, $token);

            $this->orderService->updateOrderStatus($order, $stripeOrder);

        } catch (ApiErrorException | \InvalidArgumentException $e) {
            return redirect()->route('checkout')->with(['message' => $e->getMessage()]);
        }

        DB::commit();

        // todo: Redirect to final page
        return '';
    }
}
