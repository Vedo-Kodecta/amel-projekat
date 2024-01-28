<?php

namespace App\StateMachines\ProductStatus;


class ProductActiveState extends BaseRepairStatusState
{
    function delete()
    {
        $this->product->update(['product_status_id' => 3]);
    }
}
