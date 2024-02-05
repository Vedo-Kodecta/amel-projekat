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


    public function create(array $request)
    {
        GlobalLogger::log('apiLog', 'Create products called');
        $product = Product::createProduct($request);

        Cache::forget('all_products');

        return ProductResource::make($product);
    }


    public function addFilter($searchObject, $query)
    {
        if ($searchObject->name) {
            $query->where('name', 'LIKE', '%' . $searchObject->name . '%');
        }

        if ($searchObject->valid_from) {
            $query = $query->where('valid_from', '>=', $searchObject->valid_from);
        }

        if ($searchObject->valid_to) {
            $query = $query->where('valid_to', '<=', $searchObject->valid_to);
        }

        if ($searchObject->priceGT || $searchObject->priceLTE) {
            $query = $this->applyPriceFilter($query, $searchObject);
        }

        return $query;
    }

    private function applyPriceFilter($query, $searchObject)
    {
        return $query->with(['variants' => function ($variantQuery) use ($searchObject) {
            $this->addPriceConditions($variantQuery, $searchObject);
        }])
            ->whereHas('variants', function ($variantQuery) use ($searchObject) {
                $this->addPriceConditions($variantQuery, $searchObject);
            });
    }
    private function addPriceConditions($query, $searchObject)
    {
        if ($searchObject->priceGT) {
            $query->where('price', '>', $searchObject->priceGT);
        }
        if ($searchObject->priceLTE) {
            $query->where('price', '<=', $searchObject->priceLTE);
        }
    }
    public function includeRelation($searchObject, $query)
    {
        if ($searchObject->includeProductType) {
            $query = $query->with('productType');
        }

        if ($searchObject->includeVariants) {
            $query = $query->with('variants');
        }

        if ($searchObject->includeProductStatus) {
            $query = $query->with('productStatus');
        }

        return $query;
    }
    protected function getModelClass()
    {
        return new Product();
    }

    protected function getCachedName($key = 'getPagable')
    {
        $cacheNames = [
            'getPagable' => 'all_products',
            'getOne' => 'one_product',
        ];

        return $cacheNames[$key] ?? $cacheNames['getPagable'];
    }
}
