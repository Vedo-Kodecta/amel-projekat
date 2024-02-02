<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface BaseServiceInterface
{
    public function getPageable($searchObject);
    public function getPagable(?Model $model);
    public function getOne(int $id,  $searchObject);
    public function create(array $request);
    public function update(Request $request, Model $model);
    public function remove(Model $model);
}
