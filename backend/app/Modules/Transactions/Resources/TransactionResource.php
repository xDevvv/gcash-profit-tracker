<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Transaction
 */
final class TransactionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'reference_number' => $this->reference_number,

            'wallet' => [
                'id' => $this->wallet_id,
                'name' => $this->wallet?->name,
            ],

            'user' => [
                'id' => $this->user_id,
                'name' => $this->user?->name,
            ],

            'transaction_type' => $this->transaction_type,

            'amount' => $this->amount,

            'fee' => $this->fee,

            'profit' => $this->profit,

            'status' => $this->status,

            'remarks' => $this->remarks,

            'created_at' => $this->created_at?->toISOString(),

            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
