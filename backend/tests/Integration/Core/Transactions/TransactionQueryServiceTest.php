<?php

declare(strict_types=1);

namespace Tests\Integration\Core\Transactions;

use App\Core\Enums\TransactionType;
use App\Core\Data\ValueObjects\TransactionFilters;
use App\Core\Services\Transactions\TransactionQueryService;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class TransactionQueryServiceTest extends TestCase
{
    use RefreshDatabase;

    private TransactionQueryService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(TransactionQueryService::class);
    }

    #[Test]
    public function it_filters_by_wallet(): void
    {
        $user = User::factory()->create();

        $walletA = Wallet::factory()->create();
        $walletB = Wallet::factory()->create();

        Transaction::factory()->count(3)->create([
            'wallet_id' => $walletA->id,
            'user_id' => $user->id,
        ]);

        Transaction::factory()->count(2)->create([
            'wallet_id' => $walletB->id,
            'user_id' => $user->id,
        ]);

        $filters = new TransactionFilters(
            walletId: $walletA->id,
        );

        $results = $this->service
            ->query($filters)
            ->get();

        $this->assertCount(3, $results);
    }

    #[Test]
    public function it_filters_by_user(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $walletA = Wallet::factory()->create();
        $walletB = Wallet::factory()->create();

        Transaction::factory()->count(4)->create([
            'wallet_id' => $walletA->id,
            'user_id' => $userA->id,
        ]);

        Transaction::factory()->count(2)->create([
            'wallet_id' => $walletB->id,
            'user_id' => $userB->id,
        ]);

        $filters = new TransactionFilters(
            userId: $userA->id,
        );

        $results = $this->service
            ->query($filters)
            ->get();

        $this->assertCount(4, $results);
    }

    #[Test]
    public function it_filters_by_transaction_type(): void
    {
        Transaction::factory()->count(2)->create();

        Transaction::factory()->count(3)->create();

        $filters = new TransactionFilters(
            transactionType: TransactionType::CASH_IN
        );

        $results = $this->service
            ->query($filters)
            ->get();

        $this->assertCount(5, $results);
    }

    #[Test]
    public function it_searches_reference_number(): void
    {
        Transaction::factory()->create([
            'reference_number' => 'TXN-ABC-001',
        ]);

        $filters = new TransactionFilters(
            search: 'ABC',
        );

        $results = $this->service
            ->query($filters)
            ->get();

        $this->assertCount(1, $results);

        $this->assertEquals(
            'TXN-ABC-001',
            $results->first()->reference_number,
        );
    }

    #[Test]
    public function it_sorts_by_amount(): void
    {
        Transaction::factory()->create();

        Transaction::factory()->create();

        Transaction::factory()->create();

        $filters = new TransactionFilters(
            sortBy: 'amount',
            sortDirection: 'asc',
        );

        $results = $this->service
            ->query($filters)
            ->get();

        $this->assertEquals(
            100,
            $results->first()->amount,
        );
    }

    #[Test]
    public function it_paginates_results(): void
    {
        Transaction::factory()->count(50)->create();

        $filters = new TransactionFilters(
            perPage: 10,
        );

        $page = $this->service
            ->paginate($filters);

        $this->assertCount(
            10,
            $page->items(),
        );

        $this->assertEquals(
            50,
            $page->total(),
        );
    }
}
