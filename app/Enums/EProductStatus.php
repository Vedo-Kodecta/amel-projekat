<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self DRAFT()
 * @method static self ACTIVE()
 * @method static self DELETED()
 */
class EProductStatus extends Enum
{
    const MAP_VALUE = [
        'draft' => 'DRAFT',
        'active' => 'ACTIVE',
        'deleted' => 'DELETED',
    ];
}
