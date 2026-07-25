<?php

declare(strict_types=1);

namespace App\Core\Enums;

enum TransactionStatus: string
{
    case COMPLETED = 'completed';

    case VOIDED = 'voided';
}
