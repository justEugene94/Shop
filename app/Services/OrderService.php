<?php


namespace App\Services;


use App\Models\Cart;
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
     * @param int $amount
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
     * @param string $cookieId
     *
     * @return $this
     */
    public function addProductsInOrder(Order $order, string $cookieId): OrderService
    {
        /** @var Cart $cart */
        $cart = Cart::query()
            ->select('id', 'product_id', 'qty')
            ->where('cookie_id', '=', $cookieId)
            ->get();

        foreach ($cart as $cartProduct)
        {
            /** @var Product $product */
            $product = Product::query()->findOrFail($cartProduct->product_id);

            $order->products()->attach($product->id, ['qty' => $cartProduct->qty]);

            $this->reduceQty($product, $cartProduct->qty);
        }

        return $this;
    }

    /**
     * @param Product $product
     * @param int $qty
     */
    protected function reduceQty(Product $product, int $qty)
    {
        $product->quantity -= $qty;
        $product->save();
    }

    /**
     * @param Order $order
     * @throws Stripe\Exception\ApiErrorException
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
