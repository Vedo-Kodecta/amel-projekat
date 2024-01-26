<?php

namespace App\Services;

use App\Http\Resources\ProductTypeResource;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Model;

class ProductTypeService extends BaseService
{

    private array $relations = ['products'];

    public function getAll(?Model $model = null, ?string $searchParameter = null, ?array $relationships = null)
    {
        $model = $model ?? ProductType::class;
        $relationships = $relationships ?? $this->relations;

        $data = parent::getAll(new $model, $searchParameter, $relationships);

        return ProductTypeResource::collection($data->latest()->paginate());
    }

    public function create($request)
    {
        $product = ProductType::createProductType($request);

        return ProductTypeResource::make(parent::create($product, $this->relations));
    }
}
