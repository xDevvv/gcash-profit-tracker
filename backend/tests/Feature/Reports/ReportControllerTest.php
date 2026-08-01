<?php

declare(strict_types=1);

namespace Tests\Feature\Reports;

use App\Models\Transaction;

use Illuminate\Foundation\Testing\RefreshDatabase;

use PHPUnit\Framework\Attributes\Test;

use Tests\TestCase;


final class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_daily_report(): void
    {
        Transaction::factory()
            ->count(3)
            ->create();

        $response = $this->getJson(
            '/api/reports/daily',
        );

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'transaction_count',
                'total_amount',
                'total_fees',
                'total_profit',
            ],
        ]);
    }

    #[Test]
    public function it_returns_weekly_report(): void
    {
        Transaction::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(
            '/api/reports/weekly',
        );

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'transaction_count',
                'total_amount',
                'total_fees',
                'total_profit',
            ],
        ]);
    }

    #[Test]
    public function it_returns_monthly_report(): void
    {
        Transaction::factory()
            ->count(8)
            ->create();

        $response = $this->getJson(
            '/api/reports/monthly',
        );

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'transaction_count',
                'total_amount',
                'total_fees',
                'total_profit',
            ],
        ]);
    }

    #[Test]
    public function it_returns_custom_report(): void
    {
        Transaction::factory()
            ->count(4)
            ->create();

        $response = $this->getJson(
            '/api/reports/custom?start=2026-01-01&end=2026-12-31',
        );

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'transaction_count',
                'total_amount',
                'total_fees',
                'total_profit',
            ],
        ]);
    }

    #[Test]
    public function it_returns_dashboard_statistics(): void
    {
        Transaction::factory()
            ->count(10)
            ->create();

        $response = $this->getJson(
            '/api/reports/dashboard',
        );

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'wallet_count',
                'transaction_count',
                'today_profit',
                'weekly_profit',
                'monthly_profit',
            ],
        ]);
    }
}