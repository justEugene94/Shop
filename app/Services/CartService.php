<?php


namespace App\Services;


use App\Models\Product;

class CartService
{
    /**
     * @param Product $product
     * @param array $cart
     *
     * @return array
     */
    public function addProductInCartArray(Product $product, Array $cart = []) :array
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
    public function getHtmlContent(array $cart, int $price) :string
    {
        $result = "";

        $result = $this->addCartHeader($result);

        $result = $this->addCartProducts($result, $cart);

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

        return $result;
    }

    /**
     * @param string $result
     * @param array $cart
     *
     * @return string
     */
    private function addCartProducts(string $result, array $cart): string
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

        return $result;
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

                        <a class='checkout' href='" . route('checkout.index')  ."'>Checkout</a>

                    </div>";

        return $result;
    }
}
