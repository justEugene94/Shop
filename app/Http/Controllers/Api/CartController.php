<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Goods;
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
    public function add(Request $request, int $goods_id)
    {
        $product = Goods::query()->findOrFail($goods_id);

        if (!$request->session()->has('cart')) {
            $cart = $this->addProductInCartArray($product);

            $request->session()->put('cart', $cart);
        } elseif ($request->session()->has("cart.{$goods_id}")) {
            $cart = session()->get('cart');
            $quantity = ++$cart[$goods_id]['quantity'];
            $cart[$goods_id]['total'] = $quantity * $product->price;
            session()->put('cart', $cart);
        } else {
            $cart = $request->session()->get('cart');
            $cart = $this->addProductInCartArray($product, $cart);
            $request->session()->put('cart', $cart);
        }

        $qty = $request->session()->get('qty', 0);
        $qty++;
        $request->session()->put('qty', $qty);

        $price = $request->session()->get('price', 0);
        $price += $product->price;
        $request->session()->put('price', $price);

        return response([
            'content' => $this->htmlContent($request->session()->get('cart'), $price),
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

    /**
     * @param Goods $product
     * @param array $cart
     *
     * @return array
     */
    private function addProductInCartArray(Goods $product, Array $cart = []) :array
    {
        $cart[$product->id] = [
            'name' => $product->title,
            'price' => $product->price,
            'quantity' => 1,
            'total' => $product->price,
        ];

        return $cart;
    }

    /**
     * @param array $cart
     * @param int $price
     *
     * @return string
     */
    private function htmlContent(array $cart, int $price) :string
    {
        $result = "";

        $result = $this->addCartHeader($result);

        $result = $this->addCartProducts($result);

        $result = $this->addCartTotal($result, $price);

       return $result;
    }

    /**
     * @param string $result
     * @return string
     */
    private function addCartHeader(string $result): string
    {
        $result .= "<h2>Shopping Cart</h2>

                    <div class='shopping-cart'>

                        <div class='column-labels'>
                            <label class='product-image'>Image</label>
                            <label class='product-details'>Product</label>
                            <label class='product-price'>Price</label>
                            <label class='product-quantity'>Quantity</label>
                            <label class='product-removal'>Remove</label>
                            <label class='product-line-price'>Total</label>
                        </div>";

        return $result
    }

    /**
     * @param string $result
     * @return string
     */
    private function addCartProducts(string $result): string
    {
        foreach ($cart as $id => $product) {
            $result .= "<div class='product'>
                    <div class='product-image'>
                        <img class='card-img-top img-fluid' src='http://placehold.it/200x200' alt=''>
                    </div>
                    <div class='product-details'>
                        <div class='product-title'>{$product['name']}</div>
                    </div>
                    <div class='product-price'>{$product['price']}</div>
                    <div class='product-quantity'>
                        <input type='number' value='{$product['quantity']}' min='1'>
                    </div>
                    <div class='product-removal'>
                        <form class='delete' action='' method='DELETE'>
                                    <input type='hidden' name='id' value='{{ $id }}'>
                                    <button type='submit' class='remove-product'>
                                        Remove
                                    </button>
                                </form>
                    </div>
                    <div class='product-line-price'>{$product['total']}</div>
               </div>";
        }

        return $result
    }

    /**
     * @param string $result
     * @param int $price
     *
     * @return string
     */
    private function addCartTotal(string $result, int $price): string
    {
        $result .= "<div class='totals'>
                            <div class='totals-item totals-item-total'>
                                <label>Total</label>
                                <div class='totals-value' id='cart-total'>{$price}</div>
                            </div>
                        </div>

                        <a class='checkout' href='" . route('checkout')  ."'>Checkout</a>

                    </div>";

        return $result;
    }
}
