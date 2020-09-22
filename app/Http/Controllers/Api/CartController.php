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
                    'total' => $product->price,
                ],
            ];

            $request->session()->put('cart', $cart);
        } elseif ($request->session()->has("cart.{$goods_id}")) {
            $cart = session()->get('cart');
            $quantity = ++$cart[$goods_id]['quantity'];
            $cart[$goods_id]['total'] = $quantity * $product->price;
            session()->put('cart', $cart);
        } else {
            $cart = $request->session()->get('cart');
            $cart[$goods_id] = [
                'name' => $product->title,
                'price' => $product->price,
                'quantity' => 1,
                'total' => $product->price,
            ];
            $request->session()->put('cart', $cart);
        }

        $qty = $request->session()->get('qty', 0);
        $qty++;
        $request->session()->put('qty', $qty);

        $price = $request->session()->get('price', 0);
        $price += $product->price;
        $request->session()->put('price', $price);

        return response($this->htmlContent($product, $qty),200);
    }

    private function htmlContent(Goods $product, int $qty) :string
    {
       return "<div class='product'>
                    <div class='product-image'>
                        <img class='card-img-top img-fluid' src='http://placehold.it/200x200' alt=''>
                    </div>
                    <div class='product-details'>
                        <div class='product-title'>{$product->title}</div>
                    </div>
                    <div class='product-price'>{$product->price}</div>
                    <div class='product-quantity'>
                        <input type='number' value='{$qty}' min='1'>
                    </div>
                    <div class='product-removal'>
                        <button class='remove-product'>
                            Remove
                        </button>
                    </div>
                    <div class='product-line-price'>{$product->price}</div>
               </div>";
    }
}
