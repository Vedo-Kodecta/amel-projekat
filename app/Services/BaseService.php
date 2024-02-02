<?php

namespace App\Services;

use App\Exceptions\UserException;
use App\Http\Requests\SearchObjects\BaseSearchObject;
use App\Http\Traits\CanLoadRelationships;
use App\Interfaces\BaseServiceInterface;
use App\Traits\GlobalCacheTrait;
use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class BaseService implements BaseServiceInterface
{
    use  PaginationTrait, GlobalCacheTrait;

    abstract protected function getModelClass();
    abstract protected function getCachedName($key);

    public function getPagable(?Model $model = null)
    {
        $query = $model::query();

        return $query;
    }

    public function getPageable($searchObject)
    {
        return $this->getCachedData($this->getCachedName('getPagable'), 60, function () use ($searchObject) {
            $query = $this->getModelClass()->query();

            $query = $this->includeRelation($searchObject, $query);
            $query = $this->addFilter($searchObject, $query);

            return $this->applyPagination($query);
        });
    }

    public function getOne(int $id, $searchObject)
    {
        return $this->getCachedData($this->getCachedName('getOne'), 60, function () use ($id, $searchObject) {
            $query = $this->getModelClass()->query();

            $query = $this->includeRelation($searchObject, $query);

            $result = $query->find($id);


            if (!$result) {
                throw new UserException("Resource not found!");
            }

            return $result;
        });
    }

    public function create(array $request)
    {
        return $this->getModelInstance()->create($request);
    }


    public function update(Request $request, Model $model)
    {
        return $model::query();
    }

    public function remove(Model $model)
    {
        return $model->delete();
    }

    public function addFilter($searchObject, $query)
    {
        return $query;
    }

    public function getSearchObject($params)
    {
        return new BaseSearchObject($params);
    }

    public function includeRelation($searchObject, $query)
    {
        return $query;
    }

    protected function getModelInstance(): Model
    {
        $modelClass = $this->getModelClass();

        return new $modelClass;
    }
}
