<?php

declare(strict_types=1);

namespace Tests\Feature\Wallets;

use App\Models\User;
use App\Models\Wallet;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class WalletControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_wallet_list(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Wallet::factory()->count(3)->create();

        $response = $this->getJson(
            '/api/wallets'
        );

        $response->assertOk();

        $response->assertJsonCount(
            3,
            'data',
        );
    }

    #[Test]
    public function it_creates_a_wallet(): void
    {
        
        $payload = [
            'code' => 'GCASH',
            'display_name' => 'GCash',
            'is_active' => true,
        ];
        

        $response = $this->postJson(
            '/api/wallets',
            $payload,
        );

        $response->assertCreated();

        $this->assertDatabaseHas(
            'wallets',
            [
                'code' => 'GCASH',
                'display_name' => 'GCash',
                'is_active' => true,
            ]
        );
    }

    #[Test]
    public function it_returns_a_single_wallet(): void
    {
        $wallet = Wallet::factory()->create([
            'code' => 'GCASH',
            'display_name' => 'GCash',
        ]);

        $response = $this->getJson(
            "/api/wallets/{$wallet->code}"
        );

        $response->assertOk();

        $response->assertJsonPath(
            'data.code',
            'GCASH',
        );

        $response->assertJsonPath(
            'data.display_name',
            'GCash',
        );
    }

    #[Test]
    public function it_updates_a_wallet(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $wallet = Wallet::factory()->create([
            'code' => 'GCASH',
            'display_name' => 'GCash',
        ]);

        $payload = [
            'display_name' => 'GCash Wallet',
            'is_active' => false,
        ];

        $response = $this->putJson(
            "/api/wallets/{$wallet->code}",
            $payload,
        );

        $response->assertOk();

        $this->assertDatabaseHas(
            'wallets',
            [
                'id' => $wallet->id,
                'display_name' => 'GCash Wallet',
                'is_active' => false,
            ]
        );
    }

    #[Test]
    public function it_deletes_a_wallet(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $wallet = Wallet::factory()->create([
            'code' => 'GCASH',
        ]);

        $response = $this->deleteJson(
            "/api/wallets/{$wallet->code}"
        );

        $response->assertNoContent();

        $this->assertSoftDeleted(
            'wallets',
            [
                'id' => $wallet->id,
            ]
        );
    }
}