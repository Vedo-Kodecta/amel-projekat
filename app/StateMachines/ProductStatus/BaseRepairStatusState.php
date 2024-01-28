<?php

namespace App\StateMachines\ProductStatus;

use App\Http\Requests\VariantRequest;
use App\Interfaces\ProductStatusInterface;
use App\Logging\GlobalLogger;
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
        GlobalLogger::log('apiLog', 'Tried accessing unallowed action');
        throw new Exception('Un-allowed action');
    }

    public function removeVaraint()
    {
        GlobalLogger::log('apiLog', 'Tried accessing unallowed action');
        throw new Exception('Un-allowed action');
    }

    public function activate()
    {
        GlobalLogger::log('apiLog', 'Tried accessing unallowed action');
        throw new Exception('Un-allowed action');
    }

    public function delete()
    {
        GlobalLogger::log('apiLog', 'Tried accessing unallowed action');
        throw new Exception('Un-allowed action');
    }
}
