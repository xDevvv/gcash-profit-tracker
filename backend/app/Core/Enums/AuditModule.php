<?php

declare(strict_types=1);

namespace App\Core\Enums;

enum AuditModule: string
{
    case AUTH = 'Authentication';

    case TRANSACTIONS = 'Transactions';

    case WALLETS = 'Wallets';

    case DASHBOARD = 'Dashboard';

    case USERS = 'Users';

    case PROFILE = 'Profile';

    case REPORTS = 'Reports';

    case SETTINGS = 'Settings';

    case FEE_MANAGEMENT = 'Fee Management';

    case FEE_RULES = 'Fee Rules';
}
