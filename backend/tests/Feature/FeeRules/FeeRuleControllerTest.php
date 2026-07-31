<?php

declare(strict_types=1);


namespace Tests\Feature\FeeRules;

use App\Models\User;
use App\Models\Wallet;
use App\Models\FeeRule;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FeeRuleControllerTest extends TestCase
{

    use RefreshDatabase;

    #[Test]
    public function it_returns_fee_rule_list(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        FeeRule::factory()
            ->count(3)
            ->create();

        $response = $this->getJson(
            '/api/fee-rules',
        );

        $response->assertOk();

        $response->assertJsonCount(
            3,
            'data',
        );
    }

    #[Test]
    public function it_creates_a_fee_rule(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $wallet = Wallet::factory()->create();

        User::factory()->create();

        $payload = [

            'wallet_id' => $wallet->id,

            'minimum_amount' => 0,

            'maximum_amount' => 100,

            'fee' => 3,

            'priority' => 1,

            'is_active' => true,

        ];

        $response = $this->postJson(
            '/api/fee-rules',
            $payload,
        );

        $response->assertCreated();

        $this->assertDatabaseHas(
            'fee_rules',
            [

                'wallet_id' => $wallet->id,

                'minimum_amount' => 0,

                'maximum_amount' => 100,

                'fee' => 3,

            ],
        );
    }

    #[Test]
    public function it_returns_a_single_fee_rule(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $feeRule = FeeRule::factory()->create();

        $response = $this->getJson(
            "/api/fee-rules/{$feeRule->id}",
        );

        $response->assertOk();

        $response->assertJsonFragment([
            'id' => $feeRule->id,
        ]);
    }

    #[Test]
    public function it_updates_a_fee_rule(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $wallet = Wallet::factory()->create();

        $feeRule = FeeRule::factory()->create();

        $payload = [

            'wallet_id' => $wallet->id,

            'minimum_amount' => 100,

            'maximum_amount' => 500,

            'fee' => 10,

            'priority' => 2,

            'is_active' => false,

        ];

        $response = $this->putJson(
            "/api/fee-rules/{$feeRule->id}",
            $payload,
        );

        $response->assertOk();

        $this->assertDatabaseHas(
            'fee_rules',
            [

                'id' => $feeRule->id,

                'fee' => 10,

                'priority' => 2,

            ],
        );
    }

    #[Test]
    public function it_deletes_a_fee_rule(): void
    {

        $user = User::factory()->create();
        $this->actingAs($user);
        
        $feeRule = FeeRule::factory()->create();

        $response = $this->deleteJson(
            "/api/fee-rules/{$feeRule->id}",
        );

        $response->assertNoContent();

        $this->assertSoftDeleted(
            'fee_rules',
            [
                'id' => $feeRule->id,
            ],
        );
    }
}