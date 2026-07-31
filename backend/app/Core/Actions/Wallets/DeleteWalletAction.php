<?php

declare(strict_types=1);

namespace App\Core\Actions\Wallets;

use App\Core\Enums\AuditAction;
use App\Core\Enums\AuditModule;
use App\Core\Services\Audit\AuditLogger;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

final readonly class DeleteWalletAction
{
    public function __construct(
        private AuditLogger $auditLogger,
    ) {
    }

    public function execute(
        Wallet $wallet,
        User $user,
    ): void {

        DB::transaction(function () use ($wallet, $user): void {

            $this->auditLogger->log(
                user: $user,
                module: AuditModule::WALLETS->value,
                action: AuditAction::DELETED->value,
                description: 'Deleted wallet.',
                metadata: [
                    'wallet_id' => $wallet->id,
                    'code' => $wallet->code,
                ],
            );

            $wallet->delete();
        });
    }
}
