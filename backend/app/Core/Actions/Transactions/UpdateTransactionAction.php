<?php

declare(strict_types=1);

namespace App\Core\Actions\Transactions;


use App\Core\Data\ValueObjects\FeeCalculationData;
use App\Core\Data\ValueObjects\UpdateTransactionData;
use App\Core\Enums\AuditAction;
use App\Core\Enums\AuditModule;
use App\Core\Services\Audit\AuditLogger;
use App\Core\Services\Finance\FeeCalculatorService;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

final readonly class UpdateTransactionAction
{
    public function __construct(
        private FeeCalculatorService $feeCalculator,
        private AuditLogger $auditLogger,
    ) {
    }

    public function execute(
        Transaction $transaction,
        UpdateTransactionData $data,
    ): Transaction {

        return DB::transaction(function () use (
            $transaction,
            $data,
        ) {

            $attributes = $data->toArray();

            if ($data->needsFeeRecalculation()) {

                $walletId = $data->walletId ?? $transaction->wallet_id;

                $amount = $data->amount ?? $transaction->amount;

                $fee = $this->feeCalculator->calculate(
                    new FeeCalculationData(
                        walletId: $walletId,
                        amount: $amount,
                    )
                );

                $attributes['fee'] = $fee;
                $attributes['profit'] = $fee;
            }

            $transaction->update($attributes);

            $this->auditLogger->log(
                $transaction->user,
                AuditModule::TRANSACTIONS->value,
                AuditAction::UPDATED->value,
                'Updated transaction.',
            );

            return $transaction->fresh([
                'wallet',
                'user',
            ]);
        });
    }
}
