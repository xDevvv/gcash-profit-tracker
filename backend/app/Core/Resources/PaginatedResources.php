<?php

declare(strict_types=1);

namespace App\Core\Resources;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final readonly class PaginatedResources
{
    public function __construct(
        private LengthAwarePaginator $paginator,
    ) {
    }

    /**
     * @return array<string, int>
     */
    public function meta(): array
    {
        return [
            'current_page' => $this->paginator->currentPage(),
            'last_page' => $this->paginator->lastPage(),
            'per_page' => $this->paginator->perPage(),
            'total' => $this->paginator->total(),
        ];
    }
}
