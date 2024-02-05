<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductTypeRequest;
use App\Http\Requests\SearchObjects\ProductTypeSearchObject;
use App\Http\Resources\ProductTypeResource;
use App\Services\ProductTypeService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductTypeController extends BaseController
{

    public function __construct(protected ProductTypeService $productTypeService)
    {
        parent::__construct($productTypeService);
    }

    protected $requestClass = ProductTypeRequest::class;

    public function getInsertRequestClass()
    {
        return ProductTypeRequest::class;
    }

    public function getSearchObject($params)
    {
        return new ProductTypeSearchObject($params);
    }

    public function createResourcePayload($request, $collection = false): ProductTypeResource | AnonymousResourceCollection
    {
        if ($collection) {
            return ProductTypeResource::collection($request);
        }

        return new ProductTypeResource($request);
    }
}
