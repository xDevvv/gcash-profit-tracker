<?php

declare(strict_types=1);

namespace App\Core\DTOs;

final readonly class PaginationDTO extends AbstractDTO
{
    public function __construct(
        public int $page = 1,
        public int $perPage = 15,
    ) {
    }
}
