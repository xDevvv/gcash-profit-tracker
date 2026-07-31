<?php

declare(strict_types=1);

namespace App\Modules\Wallets\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Wallet
 */
final class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'code' => $this->code,

            'display_name' => $this->display_name,

            'is_active' => $this->is_active,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}
