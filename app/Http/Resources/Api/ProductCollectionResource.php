<?php


namespace App\Http\Resources\Api;


use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Product $resource
 */
class ProductCollectionResource extends JsonResource
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
            'title' => $this->resource->title,
            'price' => $this->resource->price,
        ];
    }
}
