<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Scopes\GlobalScope;
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

    public function create($request)
    {
        $product = Product::createProduct($request);

        return ProductResource::make(parent::create($product, $this->relations));
    }

    public function addVaraint(ProductRequest $request, Product $product)
    {
        GlobalScope::checkIfFieldIsEmpty($request, 'price');

        // return GlobalScope::addCurrentUserValueToModel($order, 'mechanic_id');
    }
}
