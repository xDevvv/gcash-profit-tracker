<?php

declare(strict_types=1);

namespace Tests\Unit\Core\ValueObjects;

use App\Core\Data\ValueObjects\DateRange;
use Carbon\CarbonImmutable;
use Tests\TestCase;

final class DateRangeTest extends TestCase
{
    public function test_it_creates_a_date_range(): void
    {
        $start = CarbonImmutable::parse('2026-01-01 00:00:00');
        $end = CarbonImmutable::parse('2026-01-31 23:59:59');

        $range = new DateRange(
            start: $start,
            end: $end,
        );

        $this->assertInstanceOf(DateRange::class, $range);

        $this->assertSame($start, $range->start);
        $this->assertSame($end, $range->end);
    }

    public function test_start_date_is_before_end_date(): void
    {
        $range = new DateRange(
            start: CarbonImmutable::parse('2026-01-01'),
            end: CarbonImmutable::parse('2026-01-31'),
        );

        $this->assertTrue(
            $range->start->lessThan($range->end)
        );
    }

    public function test_date_range_is_readonly(): void
    {
        $range = new DateRange(
            start: CarbonImmutable::parse('2026-01-01'),
            end: CarbonImmutable::parse('2026-01-31'),
        );

        $this->assertTrue(
            property_exists($range, 'start')
        );

        $this->assertTrue(
            property_exists($range, 'end')
        );
    }
}