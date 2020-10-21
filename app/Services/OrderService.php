<?php


namespace App\Services;


use App\Models\Customer;
use App\Models\NPDepartment;
use App\Models\Order;
use App\Models\Status;
use Stripe;

class OrderService
{
    /**
     * @param Customer $customer
     * @param NPDepartment $department
     * @param Stripe\Order $stripeOrder
     *
     * @return Order
     */
    public function create(Customer $customer, NPDepartment $department, Stripe\Order $stripeOrder): Order
    {
        $order = new Order([
            'stripe_order_id' => $stripeOrder->id,
            'amount' => $stripeOrder->amount,
            'status_id' => Status::CREATED,
            'info' => $stripeOrder
        ]);

        $order->npDepartment()->associate($department);

        $customer->orders()->save($order);

        return $order;
    }
}
