<?php

declare(strict_types=1);

namespace App\Core\DTOs;

abstract readonly class AbstractDTO
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
