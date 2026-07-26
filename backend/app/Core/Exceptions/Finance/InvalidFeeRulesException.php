<?php

declare(strict_types=1);

namespace App\Core\Exceptions;

final class InvalidFeeRuleException extends BusinessException
{
    public static function make(): self
    {
        return new self('No matching fee rule was found.');
    }
}
