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
     * @param Stripe\PaymentIntent $paymentIntent
     *
     * @return Order
     */
    public function create(Customer $customer, NPDepartment $department, Stripe\PaymentIntent $paymentIntent, int $amount): Order
    {
        $order = new Order([
            'stripe_order_id' => $paymentIntent->id,
            'amount' => $amount,
            'status_id' => Status::CREATED,
            'info' => $paymentIntent
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
     */
    public function updateOrderStatus(Order $order): void
    {
        $paymentIntent = Stripe\PaymentIntent::retrieve($order->stripe_order_id);

        if (in_array($paymentIntent->status, $order->statuses))
        {
            $status = array_search($paymentIntent->status, $order->statuses);
            $this->saveUpdateOrderStatus($order, $status, $paymentIntent);
        }
        else
            throw new \InvalidArgumentException("Unknown status [{$paymentIntent->status}]");
    }

    /**
     * @param Order $order
     * @param string $status
     * @param Stripe\PaymentIntent $paymentIntent
     */
    public function saveUpdateOrderStatus(Order $order, string $status, Stripe\PaymentIntent $paymentIntent)
    {
        $order->status_id = (new Status)->firstOrFail('name', '=', $status)->id;
        $order->info = $paymentIntent;

        $order->save();
    }
}
