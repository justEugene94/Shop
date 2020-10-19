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
        $stripeCustomerId = $customer->stripe_customer_id;

        if ($stripeCustomerId) {
            $stripeCustomer = Stripe\Customer::retrieve($stripeCustomerId);

            if (!$this->checkDetails($customer, $stripeCustomer)) {
                $stripeCustomer = $this->update($customer, $stripeCustomer);
            }

            return $stripeCustomer;
        } else
            return $this->create($customer);
    }

    /**
     * @param Customer $customer
     *
     * @return Stripe\Customer
     * @throws Stripe\Exception\ApiErrorException
     */
    protected function create(Customer $customer): Stripe\Customer
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

    /**
     * @param Customer $customer
     * @param Stripe\Customer $stripeCustomer
     *
     * @return bool
     */
    protected function checkDetails(Customer $customer, Stripe\Customer $stripeCustomer): bool
    {
        if (
            $customer->email == $stripeCustomer->email
            ||
            $customer->phone_number == $stripeCustomer->phone
            ||
            "{$customer->first_name} {$customer->last_name}" == $stripeCustomer->name
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Customer $customer
     * @param Stripe\Customer $stripeCustomer
     *
     * @return Stripe\Customer
     * @throws Stripe\Exception\ApiErrorException
     */
    protected function update(Customer $customer, Stripe\Customer $stripeCustomer): Stripe\Customer
    {
        /** @var Stripe\Customer $stripeCustomer */
        $stripeCustomer = \Stripe\Customer::update($stripeCustomer->id, [
            'email' => $customer->email,
            'name' => "{$customer->first_name} {$customer->last_name}",
            'phone' => $customer->phone_number,
        ]);

        return $stripeCustomer;
    }
}
