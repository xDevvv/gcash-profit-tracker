<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Core\Constants\Wallets;
use App\Core\Data\DefaultFeeRules;
use App\Models\FeeRule;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class FeeRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallet = Wallet::query()
            ->where('code', Wallets::GCASH)
            ->firstOrFail();

        foreach (DefaultFeeRules::all() as $index => $rule) {

            FeeRule::query()->updateOrCreate(

                [
                    'wallet_id' => $wallet->id,
                    'minimum_amount' => $rule['minimum_amount'],
                    'maximum_amount' => $rule['maximum_amount'],
                ],

                [
                    'fee' => $rule['fee'],
                    'priority' => $index + 1,
                    'is_active' => true,
                    'effective_from' => now(),
                    'effective_until' => null,
                ]

            );
        }
    }
}
