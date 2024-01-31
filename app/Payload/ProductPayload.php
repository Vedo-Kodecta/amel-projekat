<?php

namespace App\Payload;

use App\Http\Traits\CanLoadRelationships;
use App\Logging\GlobalLogger;
use App\Traits\GlobalCacheTrait;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductPayload extends BasePayload
{
    use CanLoadRelationships, GlobalCacheTrait;

    private array $relations = ['productType', 'productStatus', 'variants'];
    private array $searchByValueArray = ['name'];
    private array $greaterThanArray = ['price','valid_from'];
    private array $lessOrEqualThanArray = ['price','valid_to'];

    public static function applyConditions(Builder $query)
    {
        $payload = new static();

        $query = $payload->searchByValue($query);
        $query = $payload->greaterThan($query);
        $query = $payload->lessOrEqualThan($query);

        $cacheKey = 'all_products_' . md5(json_encode(request()->all()));

        $result = $payload->getCachedData($cacheKey, 60, function () use ($payload, $query) {
     
            $result = $payload->applyPagination($query);

            if ($result) {
                $result->setCollection($result->getCollection()->filter(function ($product) {
                    if ($product->variants->isEmpty()) {
                        GlobalLogger::log('apiLog', 'Product ID ' . $product->id . ' has empty variants.');
                        return false; 
                    } else {
                        GlobalLogger::log('apiLog', 'Product ID ' . $product->id . ' has variants.');
                        return true; 
                    }
                }));
            }

            return $result;
        });

        return $result;
    }

    public function searchByValue($query)
    {
        foreach ($this->searchByValueArray as $column) {
            $value = request($column);

            if ($value !== null) {
                $query->where('products.' . $column, 'LIKE', '%' . $value . '%');
            }
        }

        return $query;
    }

    public function greaterThan($query)
    {
        foreach ($this->greaterThanArray as $column) {
            $valueGT = request($column . 'GT');
            $valueLTE = request($column . 'LTE');

            if ($valueGT !== null && $valueLTE !== null) {
                continue;
            }

            if ($valueGT !== null) {
               if($column === 'price'){
                 $query->with(['variants' => function ($variantQuery) use ($column, $valueGT) {
                    $variantQuery->where($column, '>', $valueGT);
                }]);
                GlobalLogger::log('apiLog', 'Greater then applied to price in variant');
               } else {
                 $query->where($column, '>', $valueGT);
                GlobalLogger::log('apiLog', 'Greater than applied to' . $column);
               }
            } 
        }

        return $query;
    }

    public function lessOrEqualThan($query)
    {
        foreach ($this->lessOrEqualThanArray as $column) {
            $valueLTE = request($column . 'LTE');
            $valueGT = request($column . 'GT');

            if ($valueLTE !== null) {
               if($column === 'price'){
                 $query->with(['variants' => function ($variantQuery) use ($column, $valueLTE, $valueGT) {
                    $variantQuery->where($column, '<=', $valueLTE);

                    if ($valueGT !== null) {
                        $variantQuery->where($column, '>', $valueGT);
                        GlobalLogger::log('apiLog', 'Contains both GT and LTE');
                    }
                }]);
                GlobalLogger::log('apiLog', 'Less or equal then applied to price');
               } else {
                 $query->where($column, '<=', $valueLTE);
                GlobalLogger::log('apiLog', 'Less or equal then applied to' . $column);
               }
            }
        }

        return $query;
    }

    public function relationship($query)
    {
        $this->loadRelationships($query, $this->relations);

        return $query;
    }
}
