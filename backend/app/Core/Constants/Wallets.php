<?php

declare(strict_types=1);

namespace App\Core\Constants;

final class Wallets
{
    public const GCASH = 'gcash';
    public const MAYA = 'maya';
    public const GOTYME = 'gotyme';

    private function __construct()
    {
        // Prevent instantiation.
    }
}
