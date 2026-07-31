<?php

declare(strict_types=1);

namespace App\Core\Data\ValueObjects;

final readonly class WalletFilters
{
    public function __construct(
        public ?string $search = null,
        public ?bool $isActive = null,
        public string $sortBy = 'display_name',
        public string $sortDirection = 'asc',
        public int $perPage = 15,
    ) {
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(
        array $data,
    ): self {

        return new self(
            search: $data['search'] ?? null,

            isActive: isset($data['is_active'])
                ? filter_var(
                    $data['is_active'],
                    FILTER_VALIDATE_BOOL,
                    FILTER_NULL_ON_FAILURE,
                )
                : null,

            sortBy: $data['sort_by'] ?? 'display_name',

            sortDirection: strtolower(
                $data['sort_direction'] ?? 'asc'
            ),

            perPage: isset($data['per_page'])
                ? (int) $data['per_page']
                : 15,
        );
    }
}
