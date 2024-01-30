<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface BaseServiceInterface
{
    public function getPagable(?Model $model);
    public function getOne(Model $model);
    public function create(mixed $request);
    public function update(Request $request, Model $model);
    public function remove(Model $model);
}
