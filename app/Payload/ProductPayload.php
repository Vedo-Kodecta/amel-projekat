<?php

namespace App\Payload;

use App\Http\Traits\CanLoadRelationships;
use App\Logging\GlobalLogger;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProductPayload extends BasePayload
{
    use CanLoadRelationships;

    private array $relations = ['productType', 'productStatus', 'variants'];
    private array $searchByValueArray = ['name'];
    private array $greaterThanArray = ['price'];
    private array $lessOrEqualThanArray = ['price'];

    public static function applyConditions(Builder $query)
    {
        $payload = new static();

        $query = $payload->searchByValue($query);
        $query = $payload->greaterThan($query);
        $query = $payload->lessOrEqualThan($query);

        // Apply pagination after modifying the query
        $result = $payload->applyPagination($query);

        if ($result) {
            $result->setCollection($result->getCollection()->filter(function ($product) {

                if ($product->variants->isEmpty()) {
                    GlobalLogger::log('apiLog', 'Product ID ' . $product->id . ' has empty variants.');
                    return false; // Exclude the product with empty variants
                } else {
                    GlobalLogger::log('apiLog', 'Product ID ' . $product->id . ' has variants.');
                    return true; // Keep the product with variants
                }
            }));
        }

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

            // Skip if both conditions are present
            if ($valueGT !== null && $valueLTE !== null) {
                continue;
            }

            if ($valueGT !== null) {
                $query->with(['variants' => function ($variantQuery) use ($column, $valueGT) {
                    $variantQuery->where($column, '>', $valueGT);
                }]);
                GlobalLogger::log('apiLog', 'Greater then applied');
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
                $query->with(['variants' => function ($variantQuery) use ($column, $valueLTE, $valueGT) {
                    $variantQuery->where($column, '<=', $valueLTE);

                    if ($valueGT !== null) {
                        $variantQuery->where($column, '>', $valueGT);
                        GlobalLogger::log('apiLog', 'Contains both GT and LTE');
                    }
                }]);
                GlobalLogger::log('apiLog', 'Less or equal then applied');
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
