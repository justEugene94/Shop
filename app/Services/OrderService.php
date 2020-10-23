<?php


namespace App\Services;


use App\Models\Customer;
use App\Models\NPDepartment;
use App\Models\Order;
use App\Models\Product;
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

    /**
     * @param Order $order
     * @param array $cart
     */
    public function addProductsInOrder(Order $order, array $cart): void
    {
        foreach ($cart as $id => $cartProduct)
        {
            /** @var Product $product */
            $product = Product::query()->findOrFail($id);

            $order->products()->attach($product->id, ['qty' => $cartProduct['quantity']]);
        }
    }

    /**
     * @param Order $order
     * @param Stripe\Order $stripeOrder
     */
    public function updateOrderStatus(Order $order, Stripe\Order $stripeOrder): void
    {
        if (in_array($stripeOrder->status, $order->statuses))
        {
            $status = array_search($stripeOrder->status, $order->statuses);
            $this->saveUpdateOrderStatus($order, $status, $stripeOrder);
        }
        else
            throw new \InvalidArgumentException("Unknown status [{$stripeOrder->status}]");
    }

    /**
     * @param Order $order
     * @param string $status
     * @param Stripe\Order $stripeOrder
     */
    public function saveUpdateOrderStatus(Order $order, string $status, Stripe\Order $stripeOrder)
    {
        $order->status_id = (new Status)->firstOrFail('name', '=', $status)->id;
        $order->info = $stripeOrder;

        $order->save();
    }
}
