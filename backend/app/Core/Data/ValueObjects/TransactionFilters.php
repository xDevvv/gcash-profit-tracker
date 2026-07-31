<?php

declare(strict_types=1);

namespace App\Core\Data\ValueObjects;
use App\Core\Enums\TransactionType;

use Carbon\CarbonImmutable;

final readonly class TransactionFilters
{
    public function __construct(
        public ?int $walletId = null,
        public ?int $userId = null,
        public readonly ?TransactionType $transactionType = null,
        public ?string $status = null,
        public ?CarbonImmutable $from = null,
        public ?CarbonImmutable $to = null,
        public ?string $search = null,
        public string $sortBy = 'created_at',
        public string $sortDirection = 'desc',
        public int $perPage = 15,
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

            userId: isset($data['user_id'])
                ? (int) $data['user_id']
                : null,

            transactionType: isset($data['transaction_type'])
            ? TransactionType::from($data['transaction_type'])
            : null,

            status: $data['status'] ?? null,

            from: isset($data['from'])
                ? CarbonImmutable::parse($data['from'])
                : null,

            to: isset($data['to'])
                ? CarbonImmutable::parse($data['to'])
                : null,

            search: $data['search'] ?? null,

            sortBy: $data['sort_by'] ?? 'created_at',

            sortDirection: strtolower(
                $data['sort_direction'] ?? 'desc'
            ),

            perPage: isset($data['per_page'])
                ? (int) $data['per_page']
                : 15,
        );
    }
}
