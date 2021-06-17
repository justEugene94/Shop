<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\PayRequest;
use App\Http\Requests\Api\Order\StoreRequest;
use App\Http\Resources\Api\OrderResource;
use App\Http\Responses\Api\Response;
use App\Models\Order;
use App\Services\CartService;
use App\Services\CustomerService;
use App\Services\NPDepartmentService;
use App\Services\OrderService;
use App\Services\StripeOrderService;
use App\Services\StripePaymentIntentService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Stripe;

class OrderController extends Controller
{
    /**
     * @var CartService
     */
    protected $cartService;

    /**
     * @var CustomerService
     */
    protected $customerService;

    /**
     * @var NPDepartmentService
     */
    protected $departmentService;

    /**
     * @var StripePaymentIntentService
     */
    protected $stripePaymentIntentService;

    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * @var StripeOrderService
     */
    protected $stripeOrderService;

    public function __construct(
                                CartService $cartService,
                                CustomerService $customerService,
                                NPDepartmentService $departmentService,
                                StripePaymentIntentService $stripePaymentIntentService,
                                OrderService $orderService,
                                StripeOrderService $stripeOrderService)
    {
        $this->cartService = $cartService;
        $this->customerService = $customerService;
        $this->departmentService = $departmentService;
        $this->stripePaymentIntentService = $stripePaymentIntentService;
        $this->orderService = $orderService;
        $this->stripeOrderService = $stripeOrderService;
    }


    /**
     * @param StoreRequest $request
     *
     * @return Response
     * @throws Stripe\Exception\ApiErrorException
     */
    public function store(StoreRequest $request): Response
    {
        if (!$this->cartService->checkProducts($request->getCookieId()))
        {
            throw new BadRequestException('No products in cart');
        }

        $amount = $this->cartService->getAmount($request->getCookieId());

        DB::beginTransaction();

        $customer = $this->customerService->firstOrCreate($request->first_name, $request->last_name, $request->email, $request->mobile_phone);

        $department = $this->departmentService->firstOrCreate($customer, $request->city, $request->np_json);

        /** @var Stripe\Order $stripeOrder */
        $paymentIntent = $this->stripePaymentIntentService->create($customer, $amount);

        $order = $this->orderService->create($customer, $department, $paymentIntent, $amount);

        $this->orderService->addProductsInOrder($order, $request->getCookieId());

        DB::commit();

        $resource = OrderResource::make($order);

        return Response::make($resource);
    }

    /**
     * @param PayRequest $request
     * @param Order $order
     *
     * @return Response
     * @throws \Exception
     */
    public function pay(PayRequest $request, Order $order): Response
    {
        $token = $request->getToken();

        if ($this->orderService->isPayed($order))
        {
            return Response::make()->addErrorMessage(__('api.orders.is_payed'), 409);
        }

        if ($this->orderService->isError($order))
        {
            return Response::make()->addErrorMessage(__('api.orders.error'), 409);
        }

        try {
            $updateStripeOrder = $this->stripeOrderService->pay($order, $token);
            $this->orderService->updateOrderStatus($order, $updateStripeOrder);
        } catch (\Exception $exception) {
            $this->orderService->updateOrderStatusWithException($order, $exception);
            throw $exception;
        }

        $resource = OrderResource::make($order);

        return Response::make($resource)->addSuccessMessage(__('api.orders.pay_success'), 200);
    }
}
