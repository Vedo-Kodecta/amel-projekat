<?php

namespace App\StateMachines\ProductStatus;

use App\Logging\GlobalLogger;

class ProductActiveState extends BaseRepairStatusState
{
    function listAvailableFunctions()
    {
        return ['delete'];
    }

    function delete()
    {
        GlobalLogger::log('apiLog', 'Status moved to deleted');
        $this->product->update(['product_status_id' => 3]);
    }
}
