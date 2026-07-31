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

    #[Test]
    public function it_validates_required_wallet_id(): void
    {
        $payload = [
            'amount' => 100,
            'transaction_type' => 'cash_in',
            'remarks' => 'Validation Test',
        ];

        $response = $this->postJson(
            '/api/transactions',
            $payload,
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'wallet_id',
            ]);
    }

    #[Test]
    public function it_validates_required_amount(): void
    {
        $wallet = Wallet::factory()->create();

        $payload = [
            'wallet_id' => $wallet->id,
            'transaction_type' => 'cash_in',
            'remarks' => 'Validation Test',
        ];

        $response = $this->postJson(
            '/api/transactions',
            $payload,
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'amount',
            ]);
    }

    #[Test]
    public function it_validates_transaction_type(): void
    {
        $wallet = Wallet::factory()->create();

        $payload = [
            'wallet_id' => $wallet->id,
            'amount' => 100,
            'transaction_type' => 'invalid_type',
            'remarks' => 'Validation Test',
        ];

        $response = $this->postJson(
            '/api/transactions',
            $payload,
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'transaction_type',
            ]);
    }

    #[Test]
    public function it_validates_positive_amount(): void
    {
        $wallet = Wallet::factory()->create();

        $payload = [
            'wallet_id' => $wallet->id,
            'amount' => 0,
            'transaction_type' => 'cash_in',
            'remarks' => 'Validation Test',
        ];

        $response = $this->postJson(
            '/api/transactions',
            $payload,
        );

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'amount',
            ]);
    }

    #[Test]
    public function it_paginates_transactions(): void
    {
        Transaction::factory()->count(20)->create();

        $response = $this->getJson('/api/transactions');

        $response
            ->assertOk()
            ->assertJsonCount(15, 'data')
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }

    #[Test]
    public function it_respects_per_page_parameter(): void
    {
        Transaction::factory()->count(20)->create();

        $response = $this->getJson(
            '/api/transactions?per_page=5'
        );

        $response
            ->assertOk()
            ->assertJsonCount(5, 'data');
    }

    #[Test]
    public function it_returns_second_page(): void
    {
        Transaction::factory()->count(20)->create();

        $response = $this->getJson(
            '/api/transactions?page=2&per_page=5'
        );

        $response
            ->assertOk()
            ->assertJsonCount(5, 'data')
            ->assertJsonPath('meta.current_page', 2);
    }
}
