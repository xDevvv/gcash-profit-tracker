<?php

declare(strict_types=1);

namespace App\Core\Services\Transactions;

use App\Core\Data\ValueObjects\TransactionData;
use App\Core\Enums\Audit\AuditAction;
use App\Core\Enums\Audit\AuditModule;
use App\Core\Services\Audit\AuditLogger;
use App\Core\Services\Finance\FeeCalculatorService;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class TransactionCreator
{
    public function __construct(
        private ReferenceNumberGenerator $referenceGenerator,
        private FeeCalculatorService $feeCalculator,
        private AuditLogger $auditLogger,
    ) {
    }

    public function create(
        TransactionData $data,
        User $user,
    ): Transaction {
        return DB::transaction(function () use ($data, $user): Transaction {

            $fee = $this->feeCalculator->calculate($data->amount);

            $transaction = Transaction::query()->create([
                'reference_number' => $this->referenceGenerator->generate(),
                'user_id' => $user->id,
                'wallet_id' => $data->walletId,
                'transaction_type' => $data->transactionType->value,
                'amount' => $data->amount,
                'fee' => $fee,
                'remarks' => $data->remarks,
            ]);

            $this->auditLogger->log(
                user: $user,
                module: AuditModule::TRANSACTIONS->value,
                action: AuditAction::CREATED->value,
                description: 'Created transaction.',
                metadata: [
                    'transaction_id' => $transaction->id,
                    'reference_number' => $transaction->reference_number,
                    'amount' => $transaction->amount,
                    'fee' => $transaction->fee,
                ],
            );

            return $transaction;
        });
    }
}
