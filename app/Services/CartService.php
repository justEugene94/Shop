<?php


namespace App\Services;

use App\Models\Cart;
use App\Models\Product;

class CartService
{
    /**
     * @param Product $product
     * @param string $cookieId
     * @param int $qty
     * @param bool $rewrite
     *
     * @return $this
     */
    public function fill(Product $product, string $cookieId, int $qty, bool $rewrite = false): CartService
    {
        /** @var Cart $cart */
        $cart = Cart::query()
            ->firstOrNew([
                'product_id' => $product->id,
                'cookie_id' => $cookieId,
            ]);

        $cart->fill([
            'qty' => $rewrite ? $qty : $cart->qty + $qty
        ]);

        return $this;
    }
}
