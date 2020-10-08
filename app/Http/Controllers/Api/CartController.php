<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Collection\Exception\NoSuchElementException;

class CartController extends Controller
{
    /**
     * @param Request $request
     * @param int $goods_id
     *
     * @return Response
     */
    public function add(Request $request, CartService $service, int $goods_id)
    {
        $product = Goods::query()->findOrFail($goods_id);

        if (!$request->session()->has('cart')) {
            $cart = $service->addProductInCartArray($product);

            $request->session()->put('cart', $cart);
        } elseif ($request->session()->has("cart.{$goods_id}")) {
            $cart = session()->get('cart');
            $quantity = ++$cart[$goods_id]['quantity'];
            $cart[$goods_id]['total'] = $quantity * $product->price;
            session()->put('cart', $cart);
        } else {
            $cart = $request->session()->get('cart');
            $cart = $service->addProductInCartArray($product, $cart);
            $request->session()->put('cart', $cart);
        }

        $qty = $request->session()->get('qty', 0);
        $qty++;
        $request->session()->put('qty', $qty);

        $price = $request->session()->get('price', 0);
        $price += $product->price;
        $request->session()->put('price', $price);

        return response([
            'content' => $service->getHtmlContent($request->session()->get('cart'), $price),
            'qty' => $qty,
            'price' => $price,
        ],200);
    }

    /**
     * @param Request $request
     * @param int $goods_id
     *
     * @return Response
     */
    public function delete(Request $request, int $goods_id)
    {
        $product = Goods::query()->findOrFail($goods_id);

        if (!$request->session()->exists("cart.{$product->id}"))
        {
            throw new NoSuchElementException('No such element in session');
        }

        $productQty = $request->session()->get("cart.{$product->id}.quantity");
        $productPriceTotal = $request->session()->get("cart.{$product->id}.total");
        $oldPrice = $request->session()->get("price");
        $oldQty = $request->session()->get("qty");

        $request->session()->pull("cart.{$product->id}");

        $price = $oldPrice - $productPriceTotal;
        $qty = $oldQty - $productQty;

        $request->session()->put('price', $price);
        $request->session()->put('qty', $qty);

        return response([
            'price' => $price,
            'qty' => $qty,
        ], 200);
    }
}
