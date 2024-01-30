<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductTypeRequest;
use App\Services\ProductTypeService;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{

    public function __construct(protected ProductTypeService $productTypeService)
    {
        $this->middleware('auth:sanctum')->only(['store', 'destroy']);
        $this->middleware('checkUserRole:2')->only(['store', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->productTypeService->getPagable();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductTypeRequest $request)
    {
        return $this->productTypeService->create($request);
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
}
