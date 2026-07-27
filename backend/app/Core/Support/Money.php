<?php

declare(strict_types=1);

namespace App\Core\Support;

final class Money
{
    private function __construct()
    {
    }

    /**
     * Convert pesos to centavos.
     */
    public static function toCentavos(float|int|string $amount): int
    {
        return (int) round(((float) $amount) * 100);
    }

    /**
     * Convert centavos to pesos.
     */
    public static function toPesos(int $centavos): float
    {
        return $centavos / 100;
    }

    /**
     * Format centavos for display.
     *
     * Example:
     * 123456 => ₱1,234.56
     */
    public static function format(int $centavos): string
    {
        return '₱' . number_format(self::toPesos($centavos), 2);
    }
}
