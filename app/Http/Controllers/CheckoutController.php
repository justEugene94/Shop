<?php


namespace App\Http\Controllers;

use App\Http\Requests\Checkout\StoreFormRequest;
use App\Models\Customer;
use App\Models\NPDepartment;
use App\Models\Order;
use App\Services\CustomerService;
use App\Services\NPDepartmentService;
use App\Services\OrderService;
use App\Services\StripePaymentIntentService;
use App\Services\StripeTokenService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Stripe\Exception\ApiErrorException;
use Stripe;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;


class CheckoutController extends Controller
{
    /** @var CustomerService */
    protected $customerService;

    /** @var NPDepartmentService */
    protected $departmentService;

    /** @var StripePaymentIntentService */
    protected $stripePaymentIntentService;

    /** @var OrderService */
    protected $orderService;

    /** @var StripeTokenService */
    protected $stripeTokenService;

    /**
     * CheckoutController constructor.
     *
     * @param CustomerService $customerService
     * @param NPDepartmentService $departmentService
     * @param StripePaymentIntentService $stripePaymentIntentService
     * @param OrderService $orderService
     * @param StripeTokenService $stripeTokenService
     */
    public function __construct(
                                CustomerService $customerService,
                                NPDepartmentService $departmentService,
                                StripePaymentIntentService $stripePaymentIntentService,
                                OrderService $orderService,
                                StripeTokenService $stripeTokenService
    )
    {
        $this->customerService = $customerService;
        $this->departmentService = $departmentService;
        $this->stripePaymentIntentService = $stripePaymentIntentService;
        $this->orderService = $orderService;
        $this->stripeTokenService = $stripeTokenService;
    }

    /**
     * @return View|RedirectResponse
     */
    public function index()
    {
        try {
            $this->checkProductsInCart();
        } catch (BadRequestException $e) {
            return redirect()->route('home')->with(['message' => $e->getMessage()]);
        }

        return view('checkout');
    }

    /**
     * @param StoreFormRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StoreFormRequest $request)
    {
        try {
            $this->checkProductsInCart();

            $amount = $request->session()->get('price');

            DB::beginTransaction();

            /** @var Customer $customer */
            $customer = $this->customerService->create($request->first_name, $request->last_name, $request->email, $request->mobile_phone);

            /** @var NPDepartment $department */
            $department = $this->departmentService->create($customer, $request->city, $request->np_json);

            /** @var Stripe\Order $stripeOrder */
            $paymentIntent = $this->stripePaymentIntentService->create($customer, $amount);

            /** @var Order $order */
            $order = $this->orderService->create($customer, $department, $paymentIntent, $amount);

            $this->orderService->addProductsInOrder($order, $request->session()->get('cart'));

        } catch (ApiErrorException | \InvalidArgumentException | BadRequestException $e) {
            return redirect()->route('checkout.index')->with(['message' => $e->getMessage()]);
        }

        DB::commit();

        return redirect()->route('checkout.payment', ['order_id' => $order->id]);
    }

    /**
     * @param int $order_id
     *
     * @return View
     */
    public function getPaymentPage(int $order_id)
    {
        $order = Order::query()->findOrFail($order_id);

        $paymentIntent = json_decode($order->info, true);

        return view('payment', ['client_secret' => $paymentIntent['client_secret']]);
    }

    protected function checkProductsInCart(): void
    {
        if (!Session::get('cart') || empty(Session::get('cart')))
        {
            throw new BadRequestException("No products in cart");
        }
    }
}
