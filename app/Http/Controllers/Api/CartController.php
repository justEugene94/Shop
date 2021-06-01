<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Cart\AddRequest;
use App\Http\Requests\Api\Cart\ClearRequest;
use App\Http\Requests\Api\Cart\DeleteRequest;
use App\Http\Requests\Api\Cart\IndexRequest;
use App\Http\Resources\Api\CartResource;
use App\Http\Responses\Api\Response;
use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;

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
     * @param IndexRequest $request
     *
     * @return Response
     */
    public function index(IndexRequest $request): Response
    {
        $cartProducts = $this->service->get($request->getCookieId());

        /** @var CartResource $resource */
        $resource = CartResource::collection($cartProducts);

        return Response::make($resource);
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
     * @param DeleteRequest $request
     *
     * @return Response
     */
    public function delete(DeleteRequest $request): Response
    {
        /** @var Product $product */
        $product = Product::query()->findOrFail($request->getProductId());

        $this->service->delete($product, $request->getCookieId());

        return Response::make()->addSuccessMessage('cart.delete.success', JsonResponse::HTTP_OK);
    }

    /**
     * @param ClearRequest $request
     *
     * @return Response
     */
    public function clear(ClearRequest $request): Response
    {
        $this->service->clear($request->getCookieId());

        return Response::make()->addSuccessMessage('cart.clear.success', JsonResponse::HTTP_OK);
    }
}
