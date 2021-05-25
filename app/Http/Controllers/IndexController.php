<?php


namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * @return View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $products = Product::query()->paginate(9);

        $this->authorize('viewAny', Product::class);

        return view('front.home', ['products' => $products]);
    }

    /**
     * @param int $product_id
     * @return View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(int $product_id)
    {
        $product = Product::query()->findOrFail($product_id);

        $this->authorize('view', $product);

        return view('front.product', ['product' => $product]);
    }
}
