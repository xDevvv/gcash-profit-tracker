<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Services\Reports;

use App\Core\Data\ValueObjects\DateRange;
use App\Core\Services\Reports\DateRangeService;
use Carbon\CarbonImmutable;
use Tests\TestCase;

final class DateRangeServiceTest extends TestCase
{
    private DateRangeService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(DateRangeService::class);
    }

    public function test_today_returns_date_range(): void
    {
        $range = $this->service->today();

        $this->assertInstanceOf(DateRange::class, $range);

        $this->assertEquals(
            CarbonImmutable::today()->startOfDay(),
            $range->start,
        );

        $this->assertEquals(
            CarbonImmutable::today()->endOfDay(),
            $range->end,
        );
    }

    public function test_this_month_returns_valid_date_range(): void
    {
        $range = $this->service->thisMonth();

        $this->assertTrue(
            $range->start->lessThan($range->end)
        );
    }

    public function test_custom_returns_given_dates(): void
    {
        $start = CarbonImmutable::parse('2026-01-01');
        $end = CarbonImmutable::parse('2026-01-31');

        $range = $this->service->custom(
            $start,
            $end,
        );

        $this->assertEquals($start->startOfDay(), $range->start);
        $this->assertEquals($end->endOfDay(), $range->end);
    }
}
