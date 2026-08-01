<?php

declare(strict_types=1);

namespace App\Core\Services\Finance;

use App\Models\FeeRule;
use App\Core\Exceptions\Finance\FeeRuleNotFoundException;
use App\Core\Data\ValueObjects\FeeCalculationData;

final readonly class FeeCalculatorService
{
    public function __construct(
        private FeeRuleEngine $engine,
    ) {
    }

    /**
     * Get the matching fee rule.
     */
    public function getFeeRule(
        FeeCalculationData $data,
    ): FeeRule {

        $rule = $this->engine->resolve(
            $data->walletId,
            $data->amount,
        );

        if ($rule === null) {
            throw FeeRuleNotFoundException::forAmount(
                $data->amount,
            );
        }

        return $rule;
    }

    /**
     * Calculate the fee.
     */
    public function calculate(
        FeeCalculationData $data,
    ): int {

        return $this
            ->getFeeRule($data)
            ->fee;
    }
}