<?php

namespace App\Services;

use App\Http\Resources\ProductTypeResource;
use App\Logging\GlobalLogger;
use App\Models\ProductType;
use App\Traits\GlobalCacheTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ProductTypeService extends BaseService
{
    use GlobalCacheTrait;

    private array $relations = ['products'];

    public function getAll(?Model $model = null, ?string $searchParameter = null, ?array $relationships = null)
    {
        GlobalLogger::log('apiLog', 'Get all product types called');

        return $this->getCachedData('all_products_types', 60, function () use ($model) {
            $model = $model ?? ProductType::class;
            $relationships = $relationships ?? $this->relations;

            $data = parent::getAll(new $model, $relationships);

            return ProductTypeResource::collection($data->latest()->paginate());
        });
    }

    public function create($request)
    {
        GlobalLogger::log('apiLog', 'Create product types called');
        $product = ProductType::createProductType($request);

        Cache::forget('all_products_types');

        return ProductTypeResource::make(parent::create($product, $this->relations));
    }
}
