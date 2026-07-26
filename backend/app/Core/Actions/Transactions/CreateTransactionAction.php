<?php

declare(strict_types=1);

namespace App\Core\Actions\Transactions;

use App\Core\Data\ValueObjects\CreateTransactionData;
use App\Core\Enums\Audit\AuditAction;
use App\Core\Enums\Audit\AuditModule;
use App\Core\Services\Audit\AuditLogger;
use App\Core\Services\Finance\FeeCalculatorService;
use App\Core\Services\Transactions\ReferenceNumberGenerator;
use App\Core\Services\Transactions\TransactionCreator;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class CreateTransactionAction
{
    public function __construct(
        private ReferenceNumberGenerator $referenceGenerator,
        private FeeCalculatorService $feeCalculator,
        private TransactionCreator $transactionCreator,
        private AuditLogger $auditLogger,
    ) {
    }

    public function execute(
        CreateTransactionData $data,
        User $user,
    ): Transaction {
        return DB::transaction(function () use ($data, $user): Transaction {

            $referenceNumber = $this->referenceGenerator->generate();

            $fee = $this->feeCalculator->calculate($data->amount);

            $transaction = $this->transactionCreator->create(
                data: $data,
                user: $user,
                referenceNumber: $referenceNumber,
                fee: $fee,
            );

            $this->auditLogger->log(
                user: $user,
                module: AuditModule::TRANSACTIONS->value,
                action: AuditAction::CREATED->value,
                description: 'Created transaction.',
                metadata: [
                    'transaction_id' => $transaction->id,
                    'reference_number' => $referenceNumber,
                    'amount' => $transaction->amount,
                    'fee' => $transaction->fee,
                ],
            );

            return $transaction;
        });
    }
}
