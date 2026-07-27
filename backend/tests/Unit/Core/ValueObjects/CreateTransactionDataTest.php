<?php

declare(strict_types=1);

namespace Tests\Unit\Core\ValueObjects;

use App\Core\Data\ValueObjects\CreateTransactionData;
use App\Core\Enums\TransactionType;
use Tests\TestCase;

final class CreateTransactionDataTest extends TestCase
{
    public function test_it_creates_from_array(): void
    {
        $dto = CreateTransactionData::fromArray([
            'wallet_id' => 1,
            'transaction_type' => 'cash_in',
            'amount' => 500,
            'remarks' => 'Testing',
        ]);

        $this->assertSame(1, $dto->walletId);

        $this->assertSame(
            TransactionType::CASH_IN,
            $dto->transactionType,
        );

        $this->assertSame(500.0, $dto->amount);

        $this->assertSame(
            'Testing',
            $dto->remarks,
        );
    }

    public function test_it_converts_to_array(): void
    {
        $dto = new CreateTransactionData(
            walletId: 1,
            transactionType: TransactionType::CASH_IN,
            amount: 500,
            remarks: 'Testing',
        );

        $this->assertSame(
            [
                'wallet_id' => 1,
                'transaction_type' => 'cash_in',
                'amount' => 500.0,
                'remarks' => 'Testing',
            ],
            $dto->toArray(),
        );
    }
}
