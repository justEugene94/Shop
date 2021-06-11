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
     *
     * @return bool
     */
    public function isPayed(Order $order): bool
    {
        return $order->status_id === Status::PAID;
    }

    /**
     * @param Order $order
     *
     * @return bool
     */
    public function isError(Order $order): bool
    {
        return $order->status_id === Status::ERROR;
    }

    public function updateOrderStatusWithException(Order $order, \Exception $exception)
    {
        $this->saveUpdateOrderStatus($order, $order::STATUS_ERROR, $exception);
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
     * @param $info
     */
    public function saveUpdateOrderStatus(Order $order, string $status, $info): void
    {
        $order->status_id = (new Status)->firstOrFail('name', '=', $status)->id;
        $order->info = $info;

        $order->save();
    }
}
