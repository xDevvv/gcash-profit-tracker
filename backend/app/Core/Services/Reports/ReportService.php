<?php

declare(strict_types=1);

namespace App\Core\Services\Reports;

use App\Core\Data\ValueObjects\DailyReportData;
use App\Core\Data\ValueObjects\DashboardStatisticsData;
use App\Core\Data\ValueObjects\ReportDateRange;
use App\Models\Transaction;
use App\Models\Wallet;
use Carbon\CarbonImmutable;

final readonly class ReportService
{

    /**
    * Generate a report for a custom date range.
    */
    public function custom(
        ReportDateRange $range,
    ): DailyReportData {
        return $this->report($range);
    }

    
    /**
     * Generate a report for a custom date range.
     */
    public function report(
        ReportDateRange $range,
    ): DailyReportData {

        $query = Transaction::query()
            ->whereBetween(
                'created_at',
                [
                    $range->start,
                    $range->end,
                ],
            );

        return new DailyReportData(
            transactionCount: (clone $query)->count(),

            totalAmount: (int) (clone $query)->sum('amount'),

            totalFees: (int) (clone $query)->sum('fee'),

            totalProfit: (int) (clone $query)->sum('fee'),
        );
    }

    /**
     * Daily report.
     */
    public function daily(): DailyReportData
    {
        return $this->report(
            new ReportDateRange(
                start: CarbonImmutable::today(),
                end: CarbonImmutable::today()->endOfDay(),
            ),
        );
    }

    /**
     * Weekly report.
     */
    public function weekly(): DailyReportData
    {
        return $this->report(
            new ReportDateRange(
                start: CarbonImmutable::now()->startOfWeek(),
                end: CarbonImmutable::now()->endOfWeek(),
            ),
        );
    }

    /**
     * Monthly report.
     */
    public function monthly(): DailyReportData
    {
        return $this->report(
            new ReportDateRange(
                start: CarbonImmutable::now()->startOfMonth(),
                end: CarbonImmutable::now()->endOfMonth(),
            ),
        );
    }

    /**
     * Dashboard statistics.
     */
    public function dashboardStatistics(): DashboardStatisticsData
    {
        return new DashboardStatisticsData(
            walletCount: Wallet::count(),

            transactionCount: Transaction::count(),

            todayProfit: $this->daily()->totalProfit,

            weeklyProfit: $this->weekly()->totalProfit,

            monthlyProfit: $this->monthly()->totalProfit,
        );
    }
}