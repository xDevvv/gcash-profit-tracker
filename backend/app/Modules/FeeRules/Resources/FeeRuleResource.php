<?php

declare(strict_types=1);

namespace App\Modules\FeeRules\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\FeeRule
 */
final class FeeRuleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(
        Request $request,
    ): array {
        return [

            'id' => $this->id,

            'wallet_id' => $this->wallet_id,

            'wallet' => $this->whenLoaded(
                'wallet',
                fn () => [
                    'id' => $this->wallet->id,
                    'code' => $this->wallet->code,
                    'display_name' => $this->wallet->display_name,
                ],
            ),

            'minimum_amount' => $this->minimum_amount,

            'maximum_amount' => $this->maximum_amount,

            'fee' => $this->fee,

            'priority' => $this->priority,

            'is_active' => $this->is_active,

            'effective_from' => $this->effective_from,

            'effective_until' => $this->effective_until,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}