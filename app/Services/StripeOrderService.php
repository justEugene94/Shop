<?php


namespace App\Services;


use App\Models\Customer;
use App\Models\Order;
use Stripe;

class StripeOrderService
{
    /** @var StripeUserService $stripeUserService */
    protected $stripeUserService;

    /**
     * StripeService constructor.
     *
     * @param StripeUserService $stripeUserService
     */
    public function __construct(StripeUserService $stripeUserService)
    {
        $this->stripeUserService = $stripeUserService;
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * @param Customer $customer
     * @param Order $order
     * @param int $amount
     *
     * @return Stripe\Order
     * @throws Stripe\Exception\ApiErrorException
     */
    public function create(Customer $customer, Order $order, int $amount): Stripe\Order
    {
        /** @var Stripe\Customer */
        $stripeCustomer = $this->stripeUserService->get($customer);

        $order = Stripe\Order::create([
            'currency' => Order::CURRENCY,
            'customer' => $stripeCustomer->id,
            'email'    => $customer->email,
            'items'    => [
                [
                    'amount' => $amount
                ]
            ]
        ]);

        return $order;
    }

    /**
     * @param Order $order
     * @param string $token
     *
     * @return Stripe\Order
     * @throws Stripe\Exception\ApiErrorException
     */
    public function pay(Order $order, string $token): Stripe\Order
    {
        /** @var Stripe\Order */
        $stripeOrder = Stripe\Order::retrieve($order->stripe_order_id);

        return $stripeOrder->pay([
            'token' => $token,
        ]);
    }
}
