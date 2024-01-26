<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariantRequest;
use App\Models\Product;
use App\Services\VariantService;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function __construct(protected VariantService $variantService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->variantService->getAll();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VariantRequest $request, Product $product)
    {
        return $this->variantService->create($request, $product);
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
