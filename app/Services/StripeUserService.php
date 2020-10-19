<?php


namespace App\Services;

use Stripe;
use App\Models\Customer;

class StripeUserService extends StripeService
{
    /**
     * @param Customer $customer
     * 
     * @return Stripe\Customer
     * @throws Stripe\Exception\ApiErrorException
     */
    public function get(Customer $customer): Stripe\Customer
    {
        $customerId = $customer->stripe_customer_id;

        if ($customerId)
        {

        }
        else
            return $this->create($customer);
    }

    /**
     * @param Customer $customer
     *
     * @return Stripe\Customer
     * @throws Stripe\Exception\ApiErrorException
     */
    public function create(Customer $customer): Stripe\Customer
    {
        /** @var Stripe\Customer $stripeCustomer */
        $stripeCustomer = \Stripe\Customer::create([
            'email' => $customer->email,
            'name' => "{$customer->first_name} {$customer->last_name}",
            'phone' => $customer->phone_number,
        ]);

        $customer->stripe_customer_id = $stripeCustomer->id;
        $customer->save();

        return $stripeCustomer;
    }
}
