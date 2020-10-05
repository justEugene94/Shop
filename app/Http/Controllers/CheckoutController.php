<?php


namespace App\Http\Controllers;


use App\Http\Requests\Checkout\StoreFormRequest;
use Illuminate\Contracts\View\View;

class CheckoutController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('checkout');
    }

    public function store(StoreFormRequest $request)
    {
        return '';
    }
}
