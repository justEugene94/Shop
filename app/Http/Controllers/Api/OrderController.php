<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @param OrderService $service
     * @param int $order_id
     */
    public function updateStatus(Request $request, OrderService $service, int $order_id)
    {
        /** @var Order $order */
        $order = Order::query()->findOrFail($order_id);

        $service->updateOrderStatus($order);
    }
}
