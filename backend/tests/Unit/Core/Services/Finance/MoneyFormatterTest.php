<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Services\Finance;

use App\Core\Services\Finance\MoneyFormatter;
use Tests\TestCase;

final class MoneyFormatterTest extends TestCase
{
    private MoneyFormatter $formatter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->formatter = app(MoneyFormatter::class);
    }

    public function test_it_formats_money_with_symbol(): void
    {
        $this->assertSame(
            '₱1,500.00',
            $this->formatter->format(1500)
        );
    }

    public function test_it_formats_money_without_symbol(): void
    {
        $this->assertSame(
            '1,500.00',
            $this->formatter->plain(1500)
        );
    }

    public function test_it_formats_decimal_values(): void
    {
        $this->assertSame(
            '₱10,000.50',
            $this->formatter->format(10000.50)
        );
    }
}
