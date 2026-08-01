<?php

declare(strict_types=1);



namespace App\Modules\Reports\Controllers;

use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

use App\Core\Services\Reports\ReportService;

use App\Modules\Reports\Requests\ReportDateRangeRequest;
use App\Modules\Reports\Resources\DailyReportResource;
use App\Modules\Reports\Resources\DashboardStatisticsResource;
use App\Core\Data\ValueObjects\ReportDateRange;

final class ReportController extends Controller
{
    public function __construct(
        private readonly ReportService $reportService,
    ) {
    }

    /**
    * Custom date range report.
    */
    public function custom(
        ReportDateRangeRequest $request,
    ): DailyReportResource {

        return new DailyReportResource(
            $this->reportService->custom(
                ReportDateRange::fromArray(
                    $request->validated(),
                ),
            ),
        );
    }

    /**
    * Dashboard statistics.
    */
    public function dashboardStatistics(): DashboardStatisticsResource
    {
        return new DashboardStatisticsResource(
            $this->reportService->dashboardStatistics(),
        );
    }

    /**
     * Daily report.
     */
    public function daily(): DailyReportResource
    {
        return new DailyReportResource(
            $this->reportService->daily(),
        );
    }

    /**
    * Weekly report.
    */
    public function weekly(): DailyReportResource
    {
        return new DailyReportResource(
            $this->reportService->weekly(),
        );
    }

    /**
    * Monthly report.
    */
    public function monthly(): DailyReportResource
    {
        return new DailyReportResource(
            $this->reportService->monthly(),
        );
    }


}