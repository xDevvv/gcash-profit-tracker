<?php

declare(strict_types=1);

namespace App\Core\Services\Reports;

use Carbon\CarbonImmutable;

final class DateRangeService
{
    /**
     * Today.
     *
     * @return array{start: CarbonImmutable, end: CarbonImmutable}
     */
    public function today(): array
    {
        $today = CarbonImmutable::today();

        return [
            'start' => $today->startOfDay(),
            'end' => $today->endOfDay(),
        ];
    }

    /**
     * Current week.
     *
     * @return array{start: CarbonImmutable, end: CarbonImmutable}
     */
    public function thisWeek(): array
    {
        $today = CarbonImmutable::today();

        return [
            'start' => $today->startOfWeek(),
            'end' => $today->endOfWeek(),
        ];
    }

    /**
     * Current month.
     *
     * @return array{start: CarbonImmutable, end: CarbonImmutable}
     */
    public function thisMonth(): array
    {
        $today = CarbonImmutable::today();

        return [
            'start' => $today->startOfMonth(),
            'end' => $today->endOfMonth(),
        ];
    }

    /**
     * Current year.
     *
     * @return array{start: CarbonImmutable, end: CarbonImmutable}
     */
    public function thisYear(): array
    {
        $today = CarbonImmutable::today();

        return [
            'start' => $today->startOfYear(),
            'end' => $today->endOfYear(),
        ];
    }

    /**
     * Custom date range.
     *
     * @return array{start: CarbonImmutable, end: CarbonImmutable}
     */
    public function custom(
        CarbonImmutable $start,
        CarbonImmutable $end,
    ): array {
        return [
            'start' => $start->startOfDay(),
            'end' => $end->endOfDay(),
        ];
    }
}
