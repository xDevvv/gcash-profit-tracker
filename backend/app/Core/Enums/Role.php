<?php

declare(strict_types=1);

namespace App\Core\Enums;

enum Role: string
{
    case ADMIN = 'admin';

    case USER = 'user';
}
