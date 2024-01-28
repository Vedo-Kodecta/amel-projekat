<?php

namespace App\StateMachines\ProductStatus;

use App\Http\Requests\VariantRequest;
use App\Interfaces\ProductStatusInterface;
use App\Models\Product;
use Exception;

abstract class BaseRepairStatusState implements ProductStatusInterface
{
    protected Product $product;

    function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function addVaraint(VariantRequest $request)
    {
        throw new Exception('Un-allowed action');
    }

    public function removeVaraint()
    {
        throw new Exception('Un-allowed action');
    }

    public function activate()
    {
        throw new Exception('Un-allowed action');
    }

    public function delete()
    {
        throw new Exception('Un-allowed action');
    }
}
