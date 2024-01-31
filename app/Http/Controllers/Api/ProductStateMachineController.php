<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariantRequest;
use App\Models\Product;
use App\Services\ProductStateMachineService;
use Illuminate\Http\Request;

class ProductStateMachineController extends Controller
{
    public function __construct(protected ProductStateMachineService $productStateMachineService)
    {
        $this->middleware('auth:sanctum')->only(['addVaraint', 'removeVariant', 'activate', 'delete']);
        $this->middleware('checkUserRole:2')->only(['addVaraint', 'removeVariant', 'activate', 'delete']);
    }

    public function addVaraint(Product $product, VariantRequest $request)
    {
        return $this->productStateMachineService->addVariant($product, $request);
    }

    public function removeVariant(Product $product)
    {
        return $this->productStateMachineService->removeVariant($product);
    }

    public function activate(Product $product)
    {
        return $this->productStateMachineService->activate($product);
    }

    public function delete(Product $product)
    {
        return $this->productStateMachineService->delete($product);
    }

     public function listAvailableFunctions(Product $product)
    {
        return $this->productStateMachineService->listAvailableFunctions($product);
    }
}
