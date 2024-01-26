<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->productService->getAll();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        return $this->productService->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /*
    *State machine API controller methods
    */
    //Second status (order_inquiry_recieved)
    public function setPrice(ProductRequest $request, Product $product)
    {
        $order = $this->productService->addVaraint($request, $product);

        // return $this->orderService->generateResponseForStateMachine($order, EStateMachineFunctions::SET_PRICE, $request);
    }
}
