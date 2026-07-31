<?php

declare(strict_types=1);

namespace App\Core\Services\Finance;

use App\Models\FeeRule;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Collection;

final class FeeRuleEngine
{
    /**
     * Find the applicable fee rule.
     */
    public function resolve(
        int $walletId,
        int $amount,
        ?CarbonInterface $date = null,
    ): ?FeeRule {

        return FeeRule::query()
            ->active()
            ->forWallet($walletId)
            ->forAmount($amount)
            ->effectiveOn($date ?? now())
            ->ordered()
            ->first();
    }

    /**
     * Find overlapping rules.
     *
     * @return Collection<int, FeeRule>
     */
    public function overlappingRules(
        int $walletId,
        int $minimum,
        int $maximum,
        ?int $ignoreId = null,
    ): Collection {

        return FeeRule::query()
            ->forWallet($walletId)
            ->active()

            ->when(
                $ignoreId,
                fn ($query) => $query->whereKeyNot($ignoreId),
            )

            ->where(function ($query) use (
                $minimum,
                $maximum,
            ) {

                $query
                    ->whereBetween(
                        'minimum_amount',
                        [$minimum, $maximum]
                    )

                    ->orWhereBetween(
                        'maximum_amount',
                        [$minimum, $maximum]
                    )

                    ->orWhere(function ($query) use (
                        $minimum,
                        $maximum,
                    ) {

                        $query
                            ->where(
                                'minimum_amount',
                                '<=',
                                $minimum,
                            )

                            ->where(
                                'maximum_amount',
                                '>=',
                                $maximum,
                            );
                    });
            })

            ->get();
    }

    /**
     * Check whether overlap exists.
     */
    public function hasOverlap(
        int $walletId,
        int $minimum,
        int $maximum,
        ?int $ignoreId = null,
    ): bool {

        return $this
            ->overlappingRules(
                $walletId,
                $minimum,
                $maximum,
                $ignoreId,
            )
            ->isNotEmpty();
    }
}