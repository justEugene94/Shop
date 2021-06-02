<?php


namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class CartService
{
    /**
     * @param string $cookieId
     * @return Collection
     */
    public function get(string $cookieId): Collection
    {
        return Cart::query()->with('product')->where('cookie_id', '=', $cookieId)->get();
    }

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

        $cart->save();

        return $this;
    }

    /**
     * @param Product $product
     * @param string $cookieId
     *
     * @return $this
     */
    public function delete(Product $product, string $cookieId): CartService
    {
        Cart::query()->where([
            ['product_id', '=', $product->id],
            ['cookie_id', '=', $cookieId]
        ])->delete();

        return $this;
    }

    /**
     * @param string $cookieId
     *
     * @return $this
     */
    public function clear(string $cookieId): CartService
    {
        Cart::query()->where('cookie_id', '=', $cookieId)->delete();

        return $this;
    }
}
