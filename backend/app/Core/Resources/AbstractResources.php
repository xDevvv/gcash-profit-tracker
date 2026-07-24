<?php

declare(strict_types=1);

namespace App\Core\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class AbstractResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    abstract public function toArray(Request $request): array;
}
