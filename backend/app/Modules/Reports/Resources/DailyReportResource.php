<?php

declare(strict_types=1);

namespace App\Modules\Reports\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Core\Data\ValueObjects\DailyReportData
 */
final class DailyReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, int>
     */
    public function toArray(
        Request $request,
    ): array {
        return [
            'transaction_count' => $this->transactionCount,
            'total_amount' => $this->totalAmount,
            'total_fees' => $this->totalFees,
            'total_profit' => $this->totalProfit,
        ];
    }
}