<?php

namespace App\Payload;

use App\Http\Traits\CanLoadRelationships;
use Illuminate\Contracts\Database\Eloquent\Builder;

class VariantPayload extends BasePayload
{
    use CanLoadRelationships;

    private array $relations = ['product'];

    public static function applyConditions(Builder $query)
    {
        $payload = new static();

        $query = $payload->greaterThan($query);
        $query = $payload->lessOrEqualThan($query);
        $query = $payload->relationship($query);

        return $payload->applyPagination($query);
    }


    public function greaterThan($query)
    {
        if (request('priceGT')) {
            $query->where('price', '>', request('priceGT'));
        }


        return $query;
    }

    public function lessOrEqualThan($query)
    {
        if (request('priceLTE')) {
            $query->where('price', '<=', request('priceLTE'));
        }

        return $query;
    }

    public function relationship($query)
    {
        $this->loadRelationships($query, $this->relations);

        return $query;
    }
}
