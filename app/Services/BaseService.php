<?php

namespace App\Services;

use App\Http\Traits\CanLoadRelationships;
use App\Interfaces\BaseServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class BaseService implements BaseServiceInterface
{
    use CanLoadRelationships;

    public function getPagable(?Model $model = null)
    {
        $query = $model::query();

        return $query;
    }

    public function getOne(Model $model)
    {
        return $model;
    }

    public function create($request)
    {
        return $request;
    }

    public function update(Request $request, Model $model)
    {
        return $model::query();
    }

    public function remove(Model $model)
    {
        return $model->delete();
    }
}
