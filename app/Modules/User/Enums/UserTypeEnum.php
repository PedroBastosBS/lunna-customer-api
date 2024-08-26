<?php

declare(strict_types=1);

namespace App\Modules\User\Enums;

enum UserTypeEnum: int
{
    case CLIENT = 1;
    case ADVERTISER = 2;
}