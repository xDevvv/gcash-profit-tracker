<?php

declare(strict_types=1);

namespace App\Core\Actions\Wallets;

use App\Core\Data\ValueObjects\CreateWalletData;
use App\Core\Enums\AuditAction;
use App\Core\Enums\AuditModule;
use App\Core\Services\Audit\AuditLogger;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

final readonly class CreateWalletAction
{
    public function __construct(
        private AuditLogger $auditLogger,
    ) {
    }

    public function execute(
        CreateWalletData $data,
        User $user,
    ): Wallet {

        return DB::transaction(function () use ($data, $user): Wallet {

            $wallet = Wallet::query()->create([
                'code' => $data->code,
                'display_name' => $data->displayName,
                'is_active' => $data->isActive,
            ]);

            $this->auditLogger->log(
                user: $user,
                module: AuditModule::WALLETS->value,
                action: AuditAction::CREATED->value,
                description: 'Created wallet.',
                metadata: [
                    'wallet_id' => $wallet->id,
                    'code' => $wallet->code,
                ],
            );

            return $wallet;
        });
    }
}
