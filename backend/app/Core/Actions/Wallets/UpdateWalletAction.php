<?php

declare(strict_types=1);

namespace App\Core\Actions\Wallets;

use App\Core\Data\ValueObjects\UpdateWalletData;
use App\Core\Enums\AuditAction;
use App\Core\Enums\AuditModule;
use App\Core\Services\Audit\AuditLogger;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

final readonly class UpdateWalletAction
{
    public function __construct(
        private AuditLogger $auditLogger,
    ) {
    }

    public function execute(
        Wallet $wallet,
        UpdateWalletData $data,
        User $user,
    ): Wallet {

        return DB::transaction(function () use ($wallet, $data, $user): Wallet {

            $wallet->update(
                $data->toArray()
            );

            $this->auditLogger->log(
                user: $user,
                module: AuditModule::WALLETS->value,
                action: AuditAction::UPDATED->value,
                description: 'Updated wallet.',
                metadata: [
                    'wallet_id' => $wallet->id,
                    'code' => $wallet->code,
                ],
            );

            return $wallet->refresh();
        });
    }
}
