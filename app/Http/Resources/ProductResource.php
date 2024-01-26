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
        return
            [
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'productType' => ProductTypeResource::make($this->whenLoaded('productType')),
                'productStatus' => ProductStatusResource::make($this->whenLoaded('productStatus')),
                'variants' => VariantResource::collection($this->whenLoaded('variants')),
            ];
    }
}
