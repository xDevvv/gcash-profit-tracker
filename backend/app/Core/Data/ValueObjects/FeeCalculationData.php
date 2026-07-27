<?php

declare(strict_types=1);

namespace App\Core\Data\ValueObjects;

final readonly class FeeCalculationData
{
    public function __construct(
        public int $walletId,
        public int $amount,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            walletId: (int) $data['wallet_id'],
            amount: (int) $data['amount'],
        );
    }

    /**
     * @return array<string, int>
     */
    public function toArray(): array
    {
        return [
            'wallet_id' => $this->walletId,
            'amount' => $this->amount,
        ];
    }
}
