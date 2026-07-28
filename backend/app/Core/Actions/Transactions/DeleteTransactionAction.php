<?php

declare(strict_types=1);

namespace App\Core\Actions\Transactions;

use App\Core\Enums\Audit\AuditAction;
use App\Core\Enums\Audit\AuditModule;
use App\Core\Services\Audit\AuditLogger;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

final readonly class DeleteTransactionAction
{
    public function __construct(
        private AuditLogger $auditLogger,
    ) {
    }

    public function execute(
        Transaction $transaction,
    ): void {

        DB::transaction(function () use ($transaction): void {

            $this->auditLogger->log(
                AuditAction::DELETED,
                AuditModule::TRANSACTION,
                $transaction,
            );

            $transaction->delete();
        });
    }
}