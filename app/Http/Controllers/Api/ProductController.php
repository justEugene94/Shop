<?php


namespace App\Http\Controllers\Api;


use App\Http\Resources\Api\ProductCollectionResource;
use App\Http\Resources\Api\ProductResource;
use App\Http\Responses\Api\Response;
use App\Models\Product;


class ProductController
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        /** @var Product $products */
        $products = Product::query()->paginate(9);

        /** @var ProductCollectionResource $resource */
        $resource = ProductCollectionResource::collection($products);

        return Response::make($resource);
    }

    /**
     * @param Product $product
     * @return Response
     */
    public function show(Product $product): Response
    {
        $resource = ProductResource::make($product);

        return Response::make($resource);
    }

    /**
     * @return Response
     */
    public function getPromo(): Response
    {
        /** @var Product $products */
        $products = Product::query()->inRandomOrder()->limit(5)->get();

        /** @var ProductCollectionResource $resource */
        $resource = ProductCollectionResource::collection($products);

        return Response::make($resource);
    }
}
