<?php


namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        $products = Product::query()->paginate(9);

        return view('home', ['products' => $products]);
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function show(int $product_id)
    {
        $product = Product::query()->findOrFail($product_id);

        return view('product', ['product' => $product]);
    }
}
