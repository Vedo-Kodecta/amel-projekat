<?php

namespace App\Services;

use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductService extends BaseService
{

    private array $relations = ['productType', 'productStatus', 'variants'];

    public function getAll(?Model $model = null, ?string $searchParameter = null, ?array $relationships = null)
    {
        $model = $model ?? Product::class;
        $relationships = $relationships ?? $this->relations;

        $data = parent::getAll(new $model, $searchParameter, $relationships);

        return ProductResource::collection($data->latest()->paginate());
    }
}
