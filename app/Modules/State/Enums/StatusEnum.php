<?php

declare(strict_types=1);

namespace App\Modules\State\Enums;

enum StatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}