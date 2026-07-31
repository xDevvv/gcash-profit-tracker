<?php

declare(strict_types=1);

namespace App\Core\Services\FeeRules;

use App\Core\Data\ValueObjects\FeeRuleFilters;
use App\Models\FeeRule;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

final class FeeRuleQueryService
{
    private const ALLOWED_SORT_COLUMNS = [
        'minimum_amount',
        'maximum_amount',
        'fee',
        'priority',
        'created_at',
        'updated_at',
    ];

    /**
     * Build the base query.
     */
    public function query(
        FeeRuleFilters $filters,
    ): Builder {

        $query = FeeRule::query()
            ->with('wallet');

        $this->applyWalletFilter(
            $query,
            $filters,
        );

        $this->applyActiveFilter(
            $query,
            $filters,
        );

        $this->applyDateFilter(
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
     * Paginate results.
     */
    public function paginate(
        FeeRuleFilters $filters,
    ): LengthAwarePaginator {

        return $this->query($filters)
            ->paginate(
                $filters->perPage,
            );
    }

    /**
     * Filter by wallet.
     */
    private function applyWalletFilter(
        Builder $query,
        FeeRuleFilters $filters,
    ): void {

        if ($filters->walletId === null) {
            return;
        }

        $query->where(
            'wallet_id',
            $filters->walletId,
        );
    }

    /**
     * Filter active/inactive.
     */
    private function applyActiveFilter(
        Builder $query,
        FeeRuleFilters $filters,
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
     * Filter by effectivity.
     */
    private function applyDateFilter(
        Builder $query,
        FeeRuleFilters $filters,
    ): void {

        if ($filters->effectiveOn === null) {
            return;
        }

        $query->effectiveOn(
            filters->effectiveOn,
        );
    }

    /**
     * Apply sorting.
     */
    private function applySorting(
        Builder $query,
        FeeRuleFilters $filters,
    ): void {

        $column = in_array(
            $filters->sortBy,
            self::ALLOWED_SORT_COLUMNS,
            true,
        )
            ? $filters->sortBy
            : 'priority';

        $direction = strtolower(
            $filters->sortDirection,
        ) === 'asc'
            ? 'asc'
            : 'desc';

        $query->orderBy(
            $column,
            $direction,
        );
    }
}