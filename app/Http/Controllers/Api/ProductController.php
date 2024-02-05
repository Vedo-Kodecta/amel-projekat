<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\SearchObjects\ProductSearchObject;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends BaseController
{
    public function __construct(protected ProductService $productService)
    {
        parent::__construct($productService);
        $this->middleware('auth:sanctum')->only(['store', 'destroy']);
        $this->middleware('checkUserRole:2')->only(['store', 'destroy']);
    }


    protected $requestClass = ProductRequest::class;

    public function getInsertRequestClass()
    {
        return ProductRequest::class;
    }

    public function getSearchObject($params)
    {
        return new ProductSearchObject($params);
    }

    public function createResourcePayload($request, $collection = false): ProductResource | AnonymousResourceCollection
    {
        if ($collection) {
            return ProductResource::collection($request);
        }

        return new ProductResource($request);
    }
}
