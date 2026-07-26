<?php

declare(strict_types=1);

namespace App\Core\Enums;

enum AuditAction: string
{
    case CREATED = 'Created';

    case UPDATED = 'Updated';

    case DELETED = 'Deleted';

    case LOGIN = 'Login';

    case LOGOUT = 'Logout';

    case VIEWED = 'Viewed';

    case EXPORTED = 'Exported';
}
