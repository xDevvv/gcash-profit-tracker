<?php

declare(strict_types=1);

namespace App\Core\Services\Wallets;

use App\Core\Data\ValueObjects\WalletFilters;
use App\Models\Wallet;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

final class WalletQueryService
{
    private const ALLOWED_SORT_COLUMNS = [
        'code',
        'display_name',
        'created_at',
    ];

    /**
     * Build the wallet query.
     */
    public function query(
        WalletFilters $filters,
    ): Builder {

        $query = Wallet::query();

        $this->applySearchFilter(
            $query,
            $filters,
        );

        $this->applyActiveFilter(
            $query,
            $filters,
        );

        $this->applySorting(
            $query,
            $filters,
        );

        return $query;
    }

    /**
     * Paginate wallets.
     */
    public function paginate(
        WalletFilters $filters,
    ): LengthAwarePaginator {

        return $this->query($filters)
            ->paginate(
                $filters->perPage,
            );
    }

    /**
    * Apply search filter.
    */
    private function applySearchFilter(
        Builder $query,
        WalletFilters $filters,
    ): void {

        if (
            $filters->search === null ||
            trim($filters->search) === ''
        ) {
            return;
        }

        $search = '%' . trim($filters->search) . '%';

        $query->where(function (Builder $query) use ($search): void {

            $query->where(
                'code',
                'like',
                $search,
            )

            ->orWhere(
                'display_name',
                'like',
                $search,
            );
        });
    }

    /**
     * Apply active filter.
     */
    private function applyActiveFilter(
        Builder $query,
        WalletFilters $filters,
    ): void {

        if ($filters->isActive === null) {
            return;
        }

        $query->where(
            'is_active',
            $filters->isActive,
        );
    }

    /**
     * Apply sorting.
     */
    private function applySorting(
        Builder $query,
        WalletFilters $filters,
    ): void {

        $column = in_array(
            $filters->sortBy,
            self::ALLOWED_SORT_COLUMNS,
            true,
        )
            ? $filters->sortBy
            : 'display_name';

        $direction = strtolower(
            $filters->sortDirection,
        ) === 'desc'
            ? 'desc'
            : 'asc';

        $query->orderBy(
            $column,
            $direction,
        );
    }

}
