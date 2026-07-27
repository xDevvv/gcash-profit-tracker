<?php

declare(strict_types=1);

namespace App\Core\Services\Transactions;

use App\Models\Transaction;

final class ReferenceNumberGenerator
{
    /**
     * Generate the next transaction reference.
     */
    public function generate(): string
    {
        $prefix = now()->format('Ymd');

        $lastTransaction = Transaction::query()
            ->whereDate('created_at', today())
            ->latest('id')
            ->first();

        $nextNumber = 1;

        if ($lastTransaction !== null) {
            $parts = explode('-', $lastTransaction->reference_number);

            $nextNumber = (int) end($parts) + 1;
        }

        return sprintf(
            'TRX-%s-%06d',
            $prefix,
            $nextNumber
        );
    }
}
