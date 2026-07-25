<?php

declare(strict_types=1);

namespace App\Core\Enums;

enum LogModule: string
{
    case AUTH = 'Authentication';

    case DASHBOARD = 'Dashboard';

    case TRANSACTIONS = 'Transactions';

    case FEE_MANAGEMENT = 'Fee Management';

    case REPORTS = 'Reports';

    case USERS = 'Users';

    case PROFILE = 'Profile';

    case SETTINGS = 'Settings';
}
