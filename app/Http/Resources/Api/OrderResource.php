<?php


namespace App\Http\Resources\Api;


use App\Models\Cart;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Order $resource
 */
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'   => $this->resource->id,
            'customer' => CustomerResource::make($this->resource->customer),
            'amount' => $this->resource->amount,
            'status' => $this->resource->status->name,
            'products' => ProductCollectionResource::collection($this->resource->products)
        ];
    }
}
