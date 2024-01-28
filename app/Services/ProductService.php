<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Scopes\GlobalScope;
use App\Payload\ProductPayload;
use Illuminate\Database\Eloquent\Model;

class ProductService extends BaseService
{

    private array $relations = ['productType', 'productStatus', 'variants'];

    public function getAll(?Model $model = null)
    {
        $model = $model ?? Product::class;
        $relationships = $relationships ?? $this->relations;

        $query = parent::getAll(new $model);

        $data = ProductPayload::applyConditions($query);

        return ProductResource::collection($data);
    }

    public function create($request)
    {
        $product = Product::createProduct($request);

        return ProductResource::make(parent::create($product, $this->relations));
    }
}
