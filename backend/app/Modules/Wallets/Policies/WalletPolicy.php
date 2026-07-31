<?php

declare(strict_types=1);

namespace App\Modules\Wallets\Policies;

use App\Models\User;
use App\Models\Wallet;

final class WalletPolicy
{
    /**
     * View wallet list.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * View a single wallet.
     */
    public function view(User $user, Wallet $wallet): bool
    {
        return true;
    }

    /**
     * Create wallet.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Update wallet.
     */
    public function update(
        User $user,
        Wallet $wallet,
    ): bool {
        return true;
    }

    /**
     * Delete wallet.
     */
    public function delete(
        User $user,
        Wallet $wallet,
    ): bool {
        return true;
    }
}
