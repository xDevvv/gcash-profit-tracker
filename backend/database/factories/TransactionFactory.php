<?php

namespace Database\Factories;

use App\Core\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\FeeRule;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'wallet_id' => Wallet::factory(),
            'fee_rule_id' => FeeRule::factory(),
            // Generate a dummy reference number by default
            'reference_number' => $this->faker->unique()->bothify('TRX-#####-?????'),
            'amount' => 100,
            'fee' => 15,
            'transaction_type' => TransactionType::CASH_IN,
            'status' => 'completed',
        ];
    }
}
