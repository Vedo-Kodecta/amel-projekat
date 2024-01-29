<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resourceArray = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'productType' => ProductTypeResource::make($this->whenLoaded('productType')),
            'productStatus' => ProductStatusResource::make($this->whenLoaded('productStatus')),
            'variants' => VariantResource::collection($this->whenLoaded('variants')),
            'activated_by' => $this->when($this->resource->offsetExists('activated_by'), $this->activated_by),
            'valid_from' => $this->when($this->resource->offsetExists('valid_from'), $this->valid_from),
            'valid_to' => $this->when($this->resource->offsetExists('valid_to'), $this->valid_to),
        ];

        return $resourceArray;
    }
}
