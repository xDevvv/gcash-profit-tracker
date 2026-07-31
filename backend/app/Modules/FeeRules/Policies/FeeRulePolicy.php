<?php

declare(strict_types=1);

namespace App\Modules\FeeRules\Policies;

use App\Models\FeeRule;
use App\Models\User;

final class FeeRulePolicy
{
    /**
     * View fee rule list.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * View a fee rule.
     */
    public function view(
        User $user,
        FeeRule $feeRule,
    ): bool {
        return true;
    }

    /**
     * Create fee rule.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Update fee rule.
     */
    public function update(
        User $user,
        FeeRule $feeRule,
    ): bool {
        return true;
    }

    /**
     * Delete fee rule.
     */
    public function delete(
        User $user,
        FeeRule $feeRule,
    ): bool {
        return true;
    }
}