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

    public function create(Customer $customer, Order $order, int $amount): Stripe\Order
    {
        /** @var Stripe\Customer $stripeCustomer */
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
    }
}
