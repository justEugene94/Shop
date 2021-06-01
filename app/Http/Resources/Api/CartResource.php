<?php


namespace App\Http\Resources\Api;


use App\Models\Cart;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Cart $resource
 */
class CartResource extends JsonResource
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
            'product' => ProductResource::make($this->resource->product),
            'qty' => $this->resource->qty,
        ];
    }
}
