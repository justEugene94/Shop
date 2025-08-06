<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsEmptyArrayWhenNoProducts()
    {
        $response = $this->getJson('/api/products');

        $response->assertSuccessful()
                ->assertJsonStructure(['result', 'pagination'])
                ->assertJsonFragment(['result' => []])
                ->assertJsonCount(0, 'result');
    }

    public function testIndexReturnsProductsWithPaginationSecondPage()
    {
        factory(Product::class, 10)->create();

        /** @var Product $product */
        $product = Product::query()->create([
            'title' => 'Test Product 1',
            'description' => 'Test Product 1 description',
            'price' => 100,
            'quantity' => 10,
        ]);

        $response = $this->getJson('/api/products?page=2');

        $response->assertSuccessful()
            ->assertJsonStructure(['result', 'pagination'])
            ->assertJsonCount(2, 'result')
            ->assertJsonFragment([
                'title' => $product->title,
                'price' => $product->price,
            ])
            ->assertJsonMissing(['description', 'quantity']);
    }

    public function testShowReturnsProduct()
    {
        /** @var Product $product */
        $product = factory(Product::class, 1)->create([
            'id' => 12,
            'title' => 'Test Product 12',
            'description' => 'Test Product 12 description',
            'price' => 100,
            'quantity' => 10,
        ])->first();

        $response = $this->getJson('/api/products/12');

        $response->assertSuccessful()
            ->assertJsonStructure(['result'])
            ->assertJsonFragment([
                'result' => [
                    'id'          => $product->id,
                    'title'       => $product->title,
                    'price'       => $product->price,
                    'description' => $product->description,
                ]
            ])->assertJsonMissing(['pagination', 'quantity']);
    }

    public function testShowReturns404ForNonExistentProduct()
    {
        $response = $this->getJson('/api/products/60');

        $response->assertStatus(404);
    }

    public function testGetPromoReturns5RandomProducts()
    {
        factory(Product::class, 10)->create();

        $response = $this->getJson('/api/promo-products');

        $response->assertSuccessful()
            ->assertJsonStructure(['result'])
            ->assertJsonCount(5, 'result')
            ->assertJsonMissing(['pagination', 'description', 'quantity']);
    }
}
