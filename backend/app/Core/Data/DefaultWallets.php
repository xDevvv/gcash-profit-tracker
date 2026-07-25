<?php

declare(strict_types=1);

namespace App\Core\Data;

final class DefaultWallets
{
    public static function all(): array
    {
        return [
            [
                'code' => Wallets::GCASH,
                'display_name' => 'GCash',
            ],
            [
                'code' => Wallets::MAYA,
                'display_name' => 'Maya',
            ],
            [
                'code' => Wallets::GOTYME,
                'display_name' => 'GoTyme',
            ],
        ];
    }
}
