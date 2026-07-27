<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class TransactionCollection extends ResourceCollection
{
    /**
     * The resource that this collection collects.
     *
     * @var string
     */
    public $collects = TransactionResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
        ];
    }

    /**
     * Add extra metadata to the response.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        return [
            'success' => true,
            'message' => 'Transactions retrieved successfully.',
        ];
    }
}
