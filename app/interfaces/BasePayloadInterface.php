<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface BasePayloadInterface
{
    public function searchByValue(Builder $query);
    public function greaterThan(Builder $query);
    public function lessOrEqualThan(Builder $query);
    public function relationship(Builder $query);
}
