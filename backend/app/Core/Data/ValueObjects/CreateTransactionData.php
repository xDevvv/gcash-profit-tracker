<?php

declare(strict_types=1);

namespace App\Core\Data\ValueObjects;

use App\Core\Data\ValueObjects\FeeCalculationData;
use App\Core\Enums\TransactionType;

final readonly class CreateTransactionData
{
    public function __construct(
        public int $walletId,
        public TransactionType $transactionType,
        public float $amount,
        public ?string $remarks = null,
    ) {
    }

    /**
     * Create a DTO from validated request data.
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            walletId: (int) $data['wallet_id'],
            transactionType: TransactionType::from($data['transaction_type']),
            amount: (float) $data['amount'],
            remarks: $data['remarks'] ?? null,
        );
    }

    /**
     * Convert DTO back to an array.
     *
     * Mainly useful for testing or logging.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'wallet_id' => $this->walletId,
            'transaction_type' => $this->transactionType->value,
            'amount' => $this->amount,
            'remarks' => $this->remarks,
        ];
    }

    /**
     * Convert this DTO into FeeCalculationData.
     */
    public function toFeeCalculationData(): FeeCalculationData
    {
        return new FeeCalculationData(
            walletId: $this->walletId,
            amount: $this->amount,
        );
    }
}
