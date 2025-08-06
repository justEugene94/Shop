<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function testAddNonExistsProductReturnsValidationError()
    {
        $response = $this->postJson('/api/cart/add', ['product_id' => 5, 'cookie_id' => Str::random(5)]);

        $response->assertStatus(422)
            ->assertJsonMissingValidationErrors(['cookie_id'])
            ->assertJsonStructure(['messages', 'validation']);
    }

    public function testAddProductWithoutCookieReturnsValidationError()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();

        $response = $this->postJson('/api/cart/add', ['product_id' => $product->id]);

        $response->assertStatus(422)
            ->assertJsonMissingValidationErrors(['product_id'])
            ->assertJsonStructure(['messages', 'validation']);
    }

    public function testIndexWithoutCookieReturnsValidationError()
    {
        $response = $this->json('GET', '/api/cart');

        $response->assertStatus(422)
            ->assertJsonStructure(['messages', 'validation']);
    }

    public function testIndexWithoutProductsReturnsEmptyArray()
    {
        $response = $this->json('GET', '/api/cart', ['cookie_id' => Str::random(5)]);

        $response->assertSuccessful()
            ->assertJsonStructure(['result' => [], 'pagination']);
    }

    public function testAddProductReturnsSuccess()
    {
        $cookieId = Str::random(5);
        $product = factory(Product::class)->create();

        $response = $this->postJson('/api/cart/add', ['product_id' => $product->id, 'cookie_id' => $cookieId]);

        $response->assertSuccessful()
            ->assertJsonStructure(['messages'])
            ->assertJsonFragment(['text' => __('cart.add.success')]);

        $this->assertDatabaseHas('carts', [
            'cookie_id' => $cookieId,
            'product_id' => $product->id,
        ]);
    }

    public function testAddProductsAndIndexShowsIt()
    {
        $cookieId = Str::random(5);

        $firstProduct = factory(Product::class)->create();
        $this->postJson('/api/cart/add', ['product_id' => $firstProduct->id, 'qty' => 2, 'cookie_id' => $cookieId]);

        $secondProduct = factory(Product::class)->create();
        $this->postJson('/api/cart/add', ['product_id' => $secondProduct->id, 'qty' => 3, 'cookie_id' => $cookieId]);

        $response = $this->json('GET', '/api/cart', ['cookie_id' => $cookieId]);

        $response->assertSuccessful()
            ->assertJsonStructure(['result'])
            ->assertJsonFragment([
                'product' => [
                    'id'          => $firstProduct->id,
                    'title'       => $firstProduct->title,
                    'price'       => $firstProduct->price,
                    'description' => $firstProduct->description,
                ],
                'qty' => 2
            ])
            ->assertJsonFragment([
                'product' => [
                    'id'          => $secondProduct->id,
                    'title'       => $secondProduct->title,
                    'price'       => $secondProduct->price,
                    'description' => $secondProduct->description,
                ],
                'qty' => 3
            ]);
    }

    public function testAddProductThenRewritesQtyAndReturnsSuccess()
    {
        $cookieId = Str::random(5);
        $product = factory(Product::class)->create();

        $this->postJson('/api/cart/add', ['product_id' => $product->id, 'qty' => 4, 'cookie_id' => $cookieId]);

        $response = $this->postJson('/api/cart/add', ['product_id' => $product->id, 'qty' => 1, 'rewrite' => true, 'cookie_id' => $cookieId]);

        $response->assertSuccessful()
            ->assertJsonStructure(['messages'])
            ->assertJsonFragment(['text' => __('cart.add.success')]);

        $this->assertDatabaseHas('carts', [
            'cookie_id' => $cookieId,
            'product_id' => $product->id,
            'qty' => 1,
        ]);
    }

    public function testAddProductThenAddProductSecondTimeAndReturnsSuccess()
    {
        $cookieId = Str::random(5);
        $product = factory(Product::class)->create();

        $this->postJson('/api/cart/add', ['product_id' => $product->id, 'qty' => 1, 'cookie_id' => $cookieId]);

        $response = $this->postJson('/api/cart/add', ['product_id' => $product->id, 'qty' => 2, 'cookie_id' => $cookieId]);

        $response->assertSuccessful()
            ->assertJsonStructure(['messages'])
            ->assertJsonFragment(['text' => __('cart.add.success')]);

        $this->assertDatabaseHas('carts', [
            'cookie_id' => $cookieId,
            'product_id' => $product->id,
            'qty' => 3,
        ]);
    }

    public function testAddProductThenDeleteItReturnsSuccess()
    {
        $cookieId = Str::random(5);
        $product = factory(Product::class)->create();

        $this->postJson('/api/cart/add', ['product_id' => $product->id, 'qty' => 1, 'cookie_id' => $cookieId]);

        $response = $this->deleteJson('/api/cart/delete', ['product_id' => $product->id, 'cookie_id' => $cookieId]);

        $response->assertSuccessful()
            ->assertJsonStructure(['messages'])
            ->assertJsonFragment(['text' => __('cart.delete.success')]);

        $this->assertDatabaseMissing('carts', [
            'cookie_id' => $cookieId,
            'product_id' => $product->id,
        ]);
    }

    public function testAddProductsThenClearCartReturnsSuccess()
    {
        $cookieId = Str::random(5);
        $this->createProducts($cookieId);

        $response = $this->deleteJson('/api/cart/clear', ['cookie_id' => $cookieId]);

        $response->assertSuccessful()
            ->assertJsonStructure(['messages'])
            ->assertJsonFragment(['text' => __('cart.clear.success')]);

        $this->assertDatabaseMissing('carts', [
            'cookie_id' => $cookieId,
        ]);
    }

    public function testAddProductsThenGetProductCount()
    {
        $cookieId = Str::random(5);
        $this->createProducts($cookieId);

        $response = $this->json('GET', '/api/cart/products-count', ['cookie_id' => $cookieId]);

        $response->assertSuccessful()
            ->assertJsonStructure(['result'])
            ->assertJsonFragment(['productsCount' => 5]);
    }

    protected function createProducts(string $cookieId): void
    {
        $this->postJson('/api/cart/add', ['product_id' => factory(Product::class)->create()->id, 'qty' => 2, 'cookie_id' => $cookieId]);
        $this->postJson('/api/cart/add', ['product_id' => factory(Product::class)->create()->id, 'qty' => 3, 'cookie_id' => $cookieId]);
    }
}
