<?php

declare(strict_types=1);

namespace App\Core\Data\ValueObjects;

final readonly class DailyReportData
{
    public function __construct(
        public int $transactionCount,
        public int $totalAmount,
        public int $totalFees,
        public int $totalProfit,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            transactionCount: (int) ($data['transaction_count'] ?? 0),
            totalAmount: (int) ($data['total_amount'] ?? 0),
            totalFees: (int) ($data['total_fees'] ?? 0),
            totalProfit: (int) ($data['total_profit'] ?? 0),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'transaction_count' => $this->transactionCount,
            'total_amount' => $this->totalAmount,
            'total_fees' => $this->totalFees,
            'total_profit' => $this->totalProfit,
        ];
    }
}