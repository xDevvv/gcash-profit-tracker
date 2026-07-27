<?php

declare(strict_types=1);

namespace App\Core\Exceptions\Transactions;

final class TransactionException extends BusinessException
{
    public static function make(string $message): self
    {
        return new self($message);
    }
}
