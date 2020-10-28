<?php


namespace App\Services;


use App\Models\Customer;
use App\Models\Order;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Customer as StripeCustomer;

class StripePaymentIntentService
{
    /** @var StripeUserService $stripeUserService */
    protected $stripeUserService;

    /**
     * StripePaymentIntentService constructor.
     *
     * @param StripeUserService $stripeUserService
     */
    public function __construct(StripeUserService $stripeUserService)
    {
        $this->stripeUserService = $stripeUserService;
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * @param Customer $customer
     * @param int $amount
     *
     * @return PaymentIntent
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function create(Customer $customer, int $amount): PaymentIntent
    {
        /** @var StripeCustomer */
        $stripeCustomer = $this->stripeUserService->get($customer);

        return PaymentIntent::create([
            'currency' => Order::CURRENCY,
            'customer' => $stripeCustomer->id,
            'receipt_email'    => $customer->email,
            'amount'    => $amount*100,
            'payment_method_types' => ['card'],
        ]);
    }

    /**
     * @param Order $order
     *
     * @return string
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getClientSecret(Order $order): string
    {
        $paymentIntent = PaymentIntent::retrieve($order->stripe_order_id);

        return $paymentIntent->client_secret;
    }
}
