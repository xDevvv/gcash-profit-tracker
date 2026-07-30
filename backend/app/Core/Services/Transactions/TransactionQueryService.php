<?php

declare(strict_types=1);

namespace App\Core\Services\Transactions;

use App\Core\Data\ValueObjects\TransactionFilters;
use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;



final class TransactionQueryService
{
    private const ALLOWED_SORT_COLUMNS = [
        'created_at',
        'amount',
        'fee',
        'profit',
        'reference_number',
        'status',
        'transaction_type',
    ];

    /**
     * Build the base transaction query.
     */
    public function query(
        TransactionFilters $filters,
    ): Builder {

        $query = Transaction::query()
            ->with([
                'wallet',
                'user',
            ]);

        $this->applyWalletFilter($query, $filters);
        $this->applyUserFilter($query, $filters);
        $this->applyTransactionTypeFilter($query, $filters);
        $this->applyStatusFilter($query, $filters);

        $this->applyDateRangeFilter($query, $filters);
        $this->applySearchFilter($query, $filters);

        $this->applySorting( $query, $filters );

        return $query;
    }

    /**
     * Paginate transactions.
     */
    public function paginate(
        TransactionFilters $filters,
    ): LengthAwarePaginator {

        return $this->query($filters)
            ->paginate($filters->perPage);
    }

    private function applyWalletFilter(
        Builder $query,
        TransactionFilters $filters,
    ): void {

        if ($filters->walletId === null) {
            return;
        }

        $query->where(
            'wallet_id',
            $filters->walletId,
        );
    }

    private function applyUserFilter(
        Builder $query,
        TransactionFilters $filters,
    ): void {

        if ($filters->userId === null) {
            return;
        }

        $query->where(
            'user_id',
            $filters->userId,
        );
    }

    private function applyTransactionTypeFilter(
        Builder $query,
        TransactionFilters $filters,
    ): void {

        if ($filters->transactionType === null) {
            return;
        }

        $query->where(
            'transaction_type',
            $filters->transactionType,
        );
    }

    private function applyStatusFilter(
        Builder $query,
        TransactionFilters $filters,
    ): void {

        if ($filters->status === null) {
            return;
        }

        $query->where(
            'status',
            $filters->status,
        );
    }

    private function applyDateRangeFilter(
        Builder $query,
        TransactionFilters $filters,
    ): void {

        if ($filters->from !== null) {

            $query->whereDate(
                'created_at',
                '>=',
                $filters->from,
            );
        }

        if ($filters->to !== null) {

            $query->whereDate(
                'created_at',
                '<=',
                $filters->to,
            );
        }
    }

    private function applySearchFilter(
        Builder $query,
        TransactionFilters $filters,
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
                'reference_number',
                'like',
                $search,
            )

            ->orWhere(
                'remarks',
                'like',
                $search,
            )

            ->orWhereHas(
                'user',
                function (Builder $query) use ($search): void {

                    $query->where(
                        'name',
                        'like',
                        $search,
                    )

                    ->orWhere(
                        'email',
                        'like',
                        $search,
                    );
                }
            );
        });
    }

    private function applySorting(
        Builder $query,
        TransactionFilters $filters,
    ): void {

        $column = in_array(
            $filters->sortBy,
            self::ALLOWED_SORT_COLUMNS,
            true,
        )
            ? $filters->sortBy
            : 'created_at';

        $direction = strtolower(
            $filters->sortDirection
        ) === 'asc'
            ? 'asc'
            : 'desc';

        $query->orderBy(
            $column,
            $direction,
        );
    }
}
