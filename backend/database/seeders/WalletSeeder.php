<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Core\Constants\Wallets;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallets = [

            [
                'code' => Wallets::GCASH,
                'display_name' => 'GCash',
                'is_active' => true,
            ],

            [
                'code' => Wallets::MAYA,
                'display_name' => 'Maya',
                'is_active' => true,
            ],

            [
                'code' => Wallets::GOTYME,
                'display_name' => 'GoTyme',
                'is_active' => true,
            ],

        ];

        foreach ($wallets as $wallet) {

            Wallet::query()->updateOrCreate(

                [
                    'code' => $wallet['code'],
                ],

                $wallet

            );
        }
    }
}
