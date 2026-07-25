<?php

declare(strict_types=1);

namespace App\Core\Services;

use App\Models\FeeRule;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class FeeCalculatorService
{
    /**
     * Get the matching fee rule.
     *
     * @throws ModelNotFoundException
     */
    public function getFeeRule(
        Wallet $wallet,
        int $amount
    ): FeeRule {
        $rule = FeeRule::query()
            ->active()
            ->forWallet($wallet->id)
            ->forAmount($amount)
            ->effectiveOn(now())
            ->ordered()
            ->first();

        if ($rule === null) {
            throw FeeRuleNotFoundException::forAmount($amount);
        }

        return $rule;
    }

    /**
     * Calculate the fee.
     */
    public function calculate(
        FeeCalculationData $wallet,
        int $amount
    ): int {
        return $this->getFeeRule(
            $wallet,
            $amount
        )->fee;
    }
}
