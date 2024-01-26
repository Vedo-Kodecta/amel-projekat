<?php

namespace App\StateMachines\ProductStatus;


class ProductDraftState extends BaseRepairStatusState
{
    function addVaraint()
    {
    }

    function removeVaraint()
    {
    }

    function activate()
    {
        $this->order->update(['product_status_id' => 2]);
    }
}
