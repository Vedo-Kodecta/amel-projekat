<?php

namespace App\Payload;

use App\Http\Traits\CanLoadRelationships;
use Illuminate\Contracts\Database\Eloquent\Builder;

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
        $query = $payload->relationship($query);

        return $payload->applyPagination($query);
    }

    public function searchByValue($query)
    {
        foreach ($this->searchByValueArray as $column) {
            $value = request($column);

            if ($value !== null) {
                $query->where($column, 'LIKE', '%' . $value . '%');
            }
        }

        return $query;
    }

    public function greaterThan($query)
    {
        foreach ($this->greaterThanArray as $column) {
            $value = request($column . 'GT');

            if ($value !== null) {
                $query->where($column, '>', $value);
            }
        }
        return $query;
    }

    public function lessOrEqualThan($query)
    {
        foreach ($this->lessOrEqualThanArray as $column) {
            $value = request($column . 'LTE');

            if ($value !== null) {
                $query->where($column, '<=', $value);
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
