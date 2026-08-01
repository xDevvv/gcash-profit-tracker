<?php

declare(strict_types=1);

namespace App\Core\Data\ValueObjects;

final readonly class DashboardStatisticsData
{
    public function __construct(
        public int $walletCount,
        public int $transactionCount,
        public int $todayProfit,
        public int $weeklyProfit,
        public int $monthlyProfit,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            walletCount: (int) ($data['wallet_count'] ?? 0),
            transactionCount: (int) ($data['transaction_count'] ?? 0),
            todayProfit: (int) ($data['today_profit'] ?? 0),
            weeklyProfit: (int) ($data['weekly_profit'] ?? 0),
            monthlyProfit: (int) ($data['monthly_profit'] ?? 0),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'wallet_count' => $this->walletCount,
            'transaction_count' => $this->transactionCount,
            'today_profit' => $this->todayProfit,
            'weekly_profit' => $this->weeklyProfit,
            'monthly_profit' => $this->monthlyProfit,
        ];
    }
}