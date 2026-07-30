<?php

declare(strict_types=1);

namespace App\Core\Data\ValueObjects;

use App\Core\Enums\TransactionType;

final readonly class UpdateTransactionData
{
    public function __construct(
        public ?int $walletId = null,
        public ?TransactionType $transactionType = null,
        public ?int $amount = null,
        public ?string $remarks = null,
    ) {
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            walletId: isset($data['wallet_id'])
                ? (int) $data['wallet_id']
                : null,

            transactionType: isset($data['transaction_type'])
                ? TransactionType::from($data['transaction_type'])
                : null,

            amount: isset($data['amount'])
                ? (int) $data['amount']
                : null,

            remarks: $data['remarks'] ?? null,
        );
    }

    /**
     * Only return fields that were actually supplied.
     *
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'wallet_id' => $this->walletId,
            'transaction_type' => $this->transactionType?->value,
            'amount' => $this->amount,
            'remarks' => $this->remarks,
        ], static fn ($value) => $value !== null);
    }

    public function needsFeeRecalculation(): bool
    {
        return $this->walletId !== null
            || $this->amount !== null;
    }
}
