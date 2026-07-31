<?php

declare(strict_types=1);

namespace App\Modules\Wallets\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class WalletCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => WalletResource::collection(
                $this->collection,
            ),
        ];
    }

    /**
     * Add pagination metadata.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        if (! method_exists($this->resource, 'total')) {
            return [];
        }

        return [
            'meta' => [
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),
            ],
        ];
    }
}
