<?php

declare(strict_types=1);

namespace App\Core\Exceptions\Finance;

use RuntimeException;

final class FeeRuleNotFoundException extends RuntimeException
{
    public static function forAmount(int $amount): self
    {
        return new self(
            "No active fee rule found for amount {$amount}."
        );
    }
}
