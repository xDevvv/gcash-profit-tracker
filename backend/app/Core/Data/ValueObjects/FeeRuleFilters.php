<?php

declare(strict_types=1);

namespace App\Core\Data\ValueObjects;

use Carbon\CarbonImmutable;

final readonly class FeeRuleFilters
{
    public function __construct(
        public ?int $walletId = null,
        public ?bool $isActive = null,
        public ?CarbonImmutable $effectiveOn = null,
        public string $sortBy = 'priority',
        public string $sortDirection = 'asc',
        public int $perPage = 15,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(
        array $data,
    ): self {

        return new self(
            walletId: isset($data['wallet_id'])
                ? (int) $data['wallet_id']
                : null,

            isActive: isset($data['is_active'])
                ? filter_var(
                    $data['is_active'],
                    FILTER_VALIDATE_BOOLEAN,
                    FILTER_NULL_ON_FAILURE,
                )
                : null,

            effectiveOn: isset($data['effective_on'])
                ? CarbonImmutable::parse(
                    $data['effective_on'],
                )
                : null,

            sortBy: $data['sort_by']
                ?? 'priority',

            sortDirection: strtolower(
                $data['sort_direction']
                    ?? 'asc',
            ),

            perPage: isset($data['per_page'])
                ? (int) $data['per_page']
                : 15,
        );
    }
}