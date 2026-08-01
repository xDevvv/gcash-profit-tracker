<?php

declare(strict_types=1);

namespace App\Modules\Reports\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Core\Data\ValueObjects\DashboardStatisticsData
 */
final class DashboardStatisticsResource extends JsonResource
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
            'wallet_count' => $this->walletCount,
            'transaction_count' => $this->transactionCount,
            'today_profit' => $this->todayProfit,
            'weekly_profit' => $this->weeklyProfit,
            'monthly_profit' => $this->monthlyProfit,
        ];
    }
}