<?php

declare(strict_types=1);

namespace App\Core\Services\Reports;

use App\Core\Data\ValueObjects\DateRange;
use Carbon\CarbonImmutable;

final class DateRangeService
{
    /**
     * Today.
     */
    public function today(): DateRange
    {
        $today = CarbonImmutable::today();

        return new DateRange(
            start: $today->startOfDay(),
            end: $today->endOfDay(),
        );
    }

    /**
     * Current week.
     */
    public function thisWeek(): DateRange
    {
        $today = CarbonImmutable::today();

        return new DateRange(
            start: $today->startOfWeek(),
            end: $today->endOfWeek(),
        );
    }

    /**
     * Current month.
     */
    public function thisMonth(): DateRange
    {
        $today = CarbonImmutable::today();

        return new DateRange(
            start: $today->startOfMonth(),
            end: $today->endOfMonth(),
        );
    }

    /**
     * Current year.
     */
    public function thisYear(): DateRange
    {
        $today = CarbonImmutable::today();

        return new DateRange(
            start: $today->startOfYear(),
            end: $today->endOfYear(),
        );
    }

    /**
     * Custom date range.
     */
    public function custom(
        CarbonImmutable $start,
        CarbonImmutable $end,
    ): DateRange {
        return new DateRange(
            start: $start->startOfDay(),
            end: $end->endOfDay(),
        );
    }
}
