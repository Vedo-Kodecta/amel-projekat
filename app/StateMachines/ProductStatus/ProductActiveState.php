<?php

namespace App\StateMachines\ProductStatus;


class ProductActiveState extends BaseRepairStatusState
{
    function delete()
    {
        $this->order->update(['product_status_id' => 3]);
    }
}
