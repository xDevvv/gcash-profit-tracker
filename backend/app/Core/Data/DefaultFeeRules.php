<?php

declare(strict_types=1);

namespace App\Core\Data;

final class DefaultFeeRules
{
    /**
     * @return array<int, array<string, int>>
     */
    public static function all(): array
    {
        return [

            [
                'minimum_amount' => 100,
                'maximum_amount' => 200,
                'fee' => 3,
            ],

            [
                'minimum_amount' => 300,
                'maximum_amount' => 500,
                'fee' => 5,
            ],

            [
                'minimum_amount' => 600,
                'maximum_amount' => 1000,
                'fee' => 10,
            ],

            // Continue up to 10,000...
        ];
    }
}
