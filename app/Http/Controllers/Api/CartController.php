<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Goods;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, int $goods_id)
    {
        $product = Goods::query()->findOrFail($goods_id);

        if (!$request->session()->has('cart')) {
            $cart = [
                $goods_id => [
                    'name' => $product->title,
                    'price' => $product->price,
                    'quantity' => 1,
                ],
            ];

            $request->session()->put('cart', $cart);
        } elseif ($request->session()->has("cart.{$goods_id}")) {
            $cart = session()->get('cart');
            $cart[$goods_id]['quantity']++;
            session()->put('cart', $cart);
        } else {
            $cart = $request->session()->get('cart');
            $cart[$goods_id] = [
                'name' => $product->title,
                'price' => $product->price,
                'quantity' => 1
            ];
            $request->session()->put('cart', $cart);
        }

        $qty = $request->session()->get('qty', 0);
        $qty++;
        $request->session()->put('qty', $qty);

        $price = $request->session()->get('price', 0);
        $price += $product->price;
        $request->session()->put('price', $price);

        return redirect()->back()->with('qty', $qty);
    }
}
