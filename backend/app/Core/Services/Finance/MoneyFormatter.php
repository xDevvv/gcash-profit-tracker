<?php

declare(strict_types=1);

namespace App\Core\Services\Finance;

final class MoneyFormatter
{
    /**
     * Currency symbol.
     */
    private const SYMBOL = '₱';

    /**
     * Format as Philippine Peso.
     */
    public function format(
        float|int $amount,
        bool $withSymbol = true,
        int $decimals = 2,
    ): string {
        $formatted = number_format(
            $amount,
            $decimals,
            '.',
            ',',
        );

        return $withSymbol
            ? self::SYMBOL . $formatted
            : $formatted;
    }

    /**
     * Format without currency symbol.
     */
    public function plain(
        float|int $amount,
        int $decimals = 2,
    ): string {
        return $this->format(
            amount: $amount,
            withSymbol: false,
            decimals: $decimals,
        );
    }
}
