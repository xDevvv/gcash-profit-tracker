<?php

declare(strict_types=1);

namespace App\Modules\FeeRules\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class FeeRuleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(
        Request $request,
    ): array {
        return [
            'data' => FeeRuleResource::collection(
                $this->collection,
            ),
        ];
    }
}