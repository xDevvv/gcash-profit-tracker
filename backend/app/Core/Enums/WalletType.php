<?php

declare(strict_types=1);

namespace App\Core\Enums;

enum WalletType: string
{
    case GCASH = 'gcash';

    case MAYA = 'maya';

    case GOTYME = 'gotyme';
}
