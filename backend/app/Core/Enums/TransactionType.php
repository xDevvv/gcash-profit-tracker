<?php

declare(strict_types=1);

namespace App\Core\Enums;

enum TransactionType: string
{
    case CASH_IN = 'cash_in';

    case CASH_OUT = 'cash_out';
}
