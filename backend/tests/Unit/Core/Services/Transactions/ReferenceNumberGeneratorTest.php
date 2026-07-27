<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Services\Transactions;

use App\Core\Services\Transactions\ReferenceNumberGenerator;
use App\Core\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\FeeRule; // Added missing model import
use App\Models\User;
use App\Models\Wallet;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class ReferenceNumberGeneratorTest extends TestCase
{
    use RefreshDatabase; // Added trait inside the class
    private ReferenceNumberGenerator $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = app(ReferenceNumberGenerator::class);
    }

    public function test_it_generates_a_reference_number(): void
    {
        $reference = $this->generator->generate();

        $this->assertNotEmpty($reference);
        $this->assertIsString($reference);
    }

    public function test_generated_reference_number_matches_expected_format(): void
    {
        $reference = $this->generator->generate();

        // Update this regex to match your generator format.
        $this->assertMatchesRegularExpression(
            '/^TRX-\d{8}-\d{6}$/',
            $reference
        );
    }

    public function test_generated_reference_numbers_are_unique(): void
    {
        $first = $this->generator->generate();

        $user = User::factory()->create();
        $wallet = Wallet::factory()->create();
        $feeRule = FeeRule::factory()->create(['wallet_id' => $wallet->id]); // Reuses the wallet

        // Save a record using the first reference number so the DB count increments
        Transaction::factory()->create([
            'reference_number' => $first,
            'user_id' => $user->id,
            'wallet_id' => $wallet->id,
            'fee_rule_id' => $feeRule->id,
            'transaction_type' => TransactionType::CASH_IN,
            'status' => 'completed',
            'amount' => 100,
            'fee' => 3,
            'remarks' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $second = $this->generator->generate();

        $this->assertNotEquals($first, $second);
    }
}
