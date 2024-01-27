<?php

namespace App\Payload;

use App\Interfaces\BasePayloadInterface;
use App\Traits\PaginationTrait;
use Exception;

class BasePayload implements BasePayloadInterface
{

    use PaginationTrait;

    public function searchByValue($query)
    {
        throw new Exception('Un-allowed action');
    }

    public function greaterThan($query)
    {
        throw new Exception('Un-allowed action');
    }

    public function lessOrEqualThan($query)
    {
        throw new Exception('Un-allowed action');
    }

    public function relationship($query)
    {
        throw new Exception('Un-allowed action');
    }
}
