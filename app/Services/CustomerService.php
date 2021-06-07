<?php


namespace App\Services;


use App\Models\Customer;

class CustomerService
{
    /**
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param string $phoneNumber
     *
     * @return Customer
     */
    public function firstOrCreate(string $first_name, string $last_name, string $email, string $phoneNumber): Customer
    {
        /** @var Customer $customer */
        $customer = Customer::query()->firstOrCreate(['phone_number' => $phoneNumber], [
            'first_name'  => $first_name,
            'last_name'   => $last_name,
            'email'       => $email,
            'phoneNumber' => $phoneNumber,
        ]);

        return $customer;
    }
}
