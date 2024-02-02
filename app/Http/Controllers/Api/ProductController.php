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

    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     return $this->productService->getPagable();
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(ProductRequest $request)
    // {
    //     parent::store($request);
    //     return $this->productService->create($request);
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show( $product)
    // {
    //     dd($product);
    //     return $this->productService->getOne($product);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Product $product)
    // {
    //     return $this->productService->remove($product);
    // }

     public function getInsertRequestClass()
    {
        return ProductRequest::class;
    }

    public function getSearchObject($params)
    {
        return new ProductSearchObject($params);
    }

      public function createResourcePayload($request, $collection = false) : ProductResource | AnonymousResourceCollection
    {
        if($collection)
        {
            return ProductResource::collection($request);
        }

        return new ProductResource($request);
    }
    
}
