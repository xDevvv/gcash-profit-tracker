<?php

declare(strict_types=1);

namespace App\Core\Services\Transactions;

use App\Core\Data\ValueObjects\CreateTransactionData;
use App\Models\Transaction;
use App\Models\User;

final class TransactionCreator
{
    public function create(
        CreateTransactionData $data,
        User $user,
        string $referenceNumber,
        float $fee,
    ): Transaction {
        return Transaction::query()->create([
            'reference_number' => $referenceNumber,
            'user_id' => $user->id,
            'wallet_id' => $data->walletId,
            'transaction_type' => $data->transactionType->value,
            'amount' => $data->amount,
            'fee' => $fee,
            'remarks' => $data->remarks,
        ]);
    }
}
