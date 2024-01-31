<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Logging\GlobalLogger;
use App\Models\Product;
use App\Models\Scopes\GlobalScope;
use App\Payload\ProductPayload;
use App\Traits\GlobalCacheTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ProductService extends BaseService
{
    use GlobalCacheTrait;

    private array $relations = ['productType', 'productStatus', 'variants'];

    public function getPagable(?Model $model = null)
    {
        GlobalLogger::log('apiLog', 'Get all products called');

        return $this->getCachedData('all_products', 60, function () use ($model) {
            $model = $model ?? Product::class;
            $query = parent::getPagable(new $model);
            $data = ProductPayload::applyConditions($query);

            return ProductResource::collection($data);
        });
    }

    public function create($request)
    {
        GlobalLogger::log('apiLog', 'Create products called');
        $product = Product::createProduct($request);

        Cache::forget('all_products');

        return ProductResource::make(parent::create($product, $this->relations));
    }

      public function getOne(Model $model, array $relations = null)
    {
        return ProductResource::make(parent::getOne($model, $this->relations));
    }
}
