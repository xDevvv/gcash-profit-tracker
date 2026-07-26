<?php

declare(strict_types=1);

namespace App\Core\Actions\Transactions;

use App\Core\Services\Transactions\TransactionCreator;
use App\Models\Transaction;
use App\Models\User;

final readonly class CreateTransactionAction
{
    public function __construct(
        private TransactionCreator $creator,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public function execute(
        array $data,
        User $user,
    ): Transaction {
        return $this->creator->create(
            data: $data,
            user: $user,
        );
    }
}
