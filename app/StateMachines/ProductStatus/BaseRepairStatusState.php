<?php

namespace App\StateMachines\ProductStatus;

use App\Interfaces\ProductStatusInterface;
use App\Models\Product;
use Exception;

abstract class BaseRepairStatusState implements ProductStatusInterface
{
    protected Product $order;

    function __construct(Product $product)
    {
        $this->order = $product;
    }

    public function addVaraint()
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
