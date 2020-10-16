<?php


namespace App\Http\Controllers;


use App\Http\Requests\Checkout\StoreFormRequest;
use App\Services\StripeService;
use Illuminate\Contracts\View\View;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('checkout');
    }

    public function store(StoreFormRequest $request, StripeService $stripeService)
    {
        if (!$request->session()->get('cart') || empty($request->session()->get('cart')))
        {
//            throw new \InvalidArgumentException('No products in cart');
            return redirect()->route('checkout')->with(['message' => 'No products in cart']);
        }

        try {
            $token = $stripeService->getToken($request->getCard());
        } catch (ApiErrorException $e) {
            return redirect()->route('checkout')->with(['message' => 'Problem with Card']);
        }

        return '';
    }
}
