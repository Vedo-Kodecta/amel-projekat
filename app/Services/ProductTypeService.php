<?php

namespace App\Services;

use App\Http\Requests\SearchObjects\ProductTypeSearchObject;
use App\Http\Resources\ProductTypeResource;
use App\Logging\GlobalLogger;
use App\Models\ProductType;
use App\Traits\GlobalCacheTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

//TODO MODIFIKUJ PTS
class ProductTypeService extends BaseService
{
    use GlobalCacheTrait;

    public function create($request)
    {
        GlobalLogger::log('apiLog', 'Create product types called');

        Cache::forget('all_products_types');

        $product = ProductType::createProductType($request);

        return ProductTypeResource::make($product);
    }

    public function addFilter($searchObject, $query)
    {
        if ($searchObject->name) {
            $query->where('name', 'LIKE', '%' . $searchObject->name . '%');
        }

        return $query;
    }

    public function includeRelation($searchObject, $query)
    {

        return $query;
    }

    public function getSearchObject($params)
    {
        return new ProductTypeSearchObject($params);
    }

    protected function getModelClass()
    {
        return new ProductType();
    }

    protected function getCachedName($key = 'getPagable')
    {
        $cacheNames = [
            'getPagable' => 'all_products_types',
            'getOne' => 'one_product_type',
        ];

        return $cacheNames[$key] ?? $cacheNames['getPagable'];
    }
}
