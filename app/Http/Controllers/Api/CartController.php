<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Cart\AddRequest;
use App\Http\Responses\Api\Response;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * @var CartService
     */
    protected $service;

    /**
     * CartController constructor.
     *
     * @param CartService $service
     */
    public function __construct(CartService $service)
    {
        $this->service = $service;
    }

    /**
     * @param AddRequest $request
     *
     * @return Response
     */
    public function add(AddRequest $request): Response
    {
        /** @var Product $product */
        $product = Product::query()->findOrFail($request->getProductId());

        $this->service->fill($product, $request->getCookieId(), $request->getQty(), $request->getRewrite());

        return Response::make()->addSuccessMessage('cart.add.success', JsonResponse::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param int $product_id
     *
     * @return Response
     */
    public function delete(Request $request, int $product_id): Response
    {
        return Response::make();
    }

    public function clear(): Response
    {
        return Response::make();
    }
}
