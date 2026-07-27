<?php

declare(strict_types=1);

namespace Tests\Integration\Core\Finance;

use PHPUnit\Framework\Attributes\DataProvider;

use App\Models\User;
use App\Models\Wallet;
use App\Models\FeeRule;


use App\Core\Data\ValueObjects\FeeCalculationData;
use App\Core\Services\Finance\FeeCalculatorService;
use App\Core\Exceptions\Finance\FeeRuleNotFoundException;


use Illuminate\Foundation\Testing\RefreshDatabase; // 1. Add import
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;



final class FeeCalculatorServiceTest extends TestCase
{
    use RefreshDatabase; // 2. Use the trait
    private FeeCalculatorService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(FeeCalculatorService::class);
    }

    // public static function feeProvider(): array
    // {
    //     return [
    //         '100 => 3' =>[
    //         new FeeCalculationData(walletId: 1,amount: 100),
    //         3,   // expected fee
    //     ],
    //         '300 => 5' => [
    //             new FeeCalculationData(walletId: 1,amount: 300),
    //             5,   // expected fee
    //         ],
    //         '600 => 10' => [
    //             new FeeCalculationData(walletId: 1,amount: 600),
    //             10,  // expected fee
    //         ],
    //     ];
    // }

    #[Test]
    public function it_calculates_fee_for_100(): void
    {
        $user = User::factory()->create();

        $wallet = Wallet::factory()->create([]);

        FeeRule::factory()->create([
            'wallet_id' => $wallet->id,
            'minimum_amount' => 301,
            'maximum_amount' => 559,
            'fee' => 10,
            'is_active' => true,
        ]);

        $fee = $this->service->calculate(
            new FeeCalculationData(
                walletId: $wallet->id,
                amount: 301,
            )
        );

        $this->assertSame(10, $fee);
    }

    #[Test]
    public function test_it_throws_exception_for_invalid_amount(): void
    {
        $this->expectException(FeeRuleNotFoundException::class);

        $this->service->calculate(new FeeCalculationData(walletId: 1,amount: 999999));
    }
}
