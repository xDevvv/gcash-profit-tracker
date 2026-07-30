<?php

declare(strict_types=1);

namespace Tests\Feature\Transactions;

use App\Core\Enums\TransactionType;
use App\Models\FeeRule;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_transaction_list(): void
    {
        Transaction::factory()->count(5)->create();

        $response = $this->getJson('/api/transactions');

        $response->assertOk()->assertJsonCount(5, 'data');
    }

    #[Test]
    public function it_creates_a_transaction(): void
    {
        $user = User::factory()->create();

        $wallet = Wallet::factory()->create();

        FeeRule::factory()->create([
            'wallet_id' => $wallet->id,
            'minimum_amount' => 0,
            'maximum_amount' => 1000,
            'fee' => 3,
            'is_active' => true,
        ]);

        $payload = [
            'wallet_id' => $wallet->id,
            'fee_rule_id' => 3,
            'amount' => 100,
            'transaction_type' => 'cash_in',
            'remarks' => 'Feature Test',
        ];

        $response = $this->postJson(
            '/api/transactions',
            $payload,
        );

        $response->assertCreated();

        $this->assertDatabaseHas('transactions', [
            'wallet_id' => $wallet->id,
            'amount' => 100,
        ]);
    }

    #[Test]
    public function it_returns_a_single_transaction(): void
    {
        $user = User::factory()->create();

        $wallet = Wallet::factory()->create();

        $feeRule = FeeRule::factory()->create([
            'wallet_id' => $wallet->id,
            'minimum_amount' => 0,
            'maximum_amount' => 1000,
            'fee' => 3,
            'is_active' => true,
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'wallet_id' => $wallet->id,
            'fee_rule_id' => $feeRule->id,
            'amount' => 100,
            'fee' => 3,
        ]);

        $response = $this->getJson(
            "/api/transactions/{$transaction->id}"
        );

        $response
            ->assertOk()
            ->assertJsonFragment([
                'id' => $transaction->id,
                'amount' => 100,
                'fee' => 3,
            ]);
    }

    #[Test]
    public function it_updates_a_transaction(): void
    {
        $user = User::factory()->create();

        $wallet = Wallet::factory()->create();

        $feeRule = FeeRule::factory()->create([
            'wallet_id' => $wallet->id,
            'minimum_amount' => 0,
            'maximum_amount' => 1000,
            'fee' => 3,
            'is_active' => true,
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'wallet_id' => $wallet->id,
            'fee_rule_id' => $feeRule->id,
            'transaction_type' => 'cash_in',
            'amount' => 100,
            'fee' => 3,
            'remarks' => 'Old remarks',
        ]);

        $payload = [
            'amount' => 300,
            'transaction_type' => 'cash_out',
            'remarks' => 'Updated remarks',
        ];

        $response = $this->putJson(
            "/api/transactions/{$transaction->id}",
            $payload,
        );

        $response
            ->assertOk()
            ->assertJsonFragment([
                'amount' => 300,
                'remarks' => 'Updated remarks',
            ]);

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'amount' => 300,
            'remarks' => 'Updated remarks',
        ]);
    }

    #[Test]
    public function it_deletes_a_transaction(): void
    {
        $user = User::factory()->create();

        $wallet = Wallet::factory()->create();

        $feeRule = FeeRule::factory()->create([
            'wallet_id' => $wallet->id,
            'minimum_amount' => 0,
            'maximum_amount' => 1000,
            'fee' => 3,
            'is_active' => true,
        ]);

        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'wallet_id' => $wallet->id,
            'fee_rule_id' => $feeRule->id,
            'amount' => 100,
            'fee' => 3,
        ]);

        $response = $this->deleteJson(
            "/api/transactions/{$transaction->id}"
        );

        $response->assertNoContent();

        $this->assertSoftDeleted('transactions', [
            'id' => $transaction->id,
        ]);
    }
}
