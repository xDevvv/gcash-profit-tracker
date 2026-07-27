<?php

declare(strict_types=1);

namespace App\Core\Services\Finance;

use App\Models\FeeRule;
use App\Core\Exceptions\Finance\FeeRuleNotFoundException;
use App\Core\Data\ValueObjects\FeeCalculationData;

use Illuminate\Database\Eloquent\ModelNotFoundException;

final class FeeCalculatorService
{
    /**
     * Get the matching fee rule.
     *
     * @throws ModelNotFoundException
     */
    public function getFeeRule(
        FeeCalculationData $data,
    ): FeeRule
    {
        $rule = FeeRule::query()
            ->active()
            ->forWallet($data->walletId)
            ->forAmount($data->amount)
            ->effectiveOn(now())
            ->ordered()
            ->first();

        if ($rule === null) {
            throw FeeRuleNotFoundException::forAmount(
                $data->amount
            );
        }

        return $rule;
    }

    /**
     * Calculate the fee.
     */
    public function calculate( FeeCalculationData $data ): int
    {
        return $this->getFeeRule($data)->fee;
    }
}
