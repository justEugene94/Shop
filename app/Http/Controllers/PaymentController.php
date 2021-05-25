<?php


namespace App\Http\Controllers;


use App\Models\Order;
use App\Services\StripePaymentIntentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Stripe\Exception\ApiErrorException;

class PaymentController extends Controller
{
    /** @var StripePaymentIntentService */
    protected $service;

    /**
     * PaymentController constructor.
     *
     * @param StripePaymentIntentService $service
     */
    public function __construct(StripePaymentIntentService $service)
    {
        $this->service = $service;
    }

    /**
     * @param int $order_id
     * @return RedirectResponse|View
     */
    public function index(int $order_id)
    {
        /** @var Order $order */
        $order = Order::query()->findOrFail($order_id);

        try {
            $clientSecret = $this->service->getClientSecret($order);
        }
        catch (ApiErrorException $e){
            return redirect()->route('checkout.index')->with('massege', $e->getMessage());
        }

        return view('front.payment', [
            'client_secret' => $clientSecret,
            'order_id' => $order->id,
            'first_name' => $order->customer->first_name,
            'last_name' =>$order->customer->last_name,
        ]);
    }
}
