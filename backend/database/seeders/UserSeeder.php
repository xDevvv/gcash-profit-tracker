<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->admin()
            ->create([
                'name' => 'System Administrator',
                'email' => 'admin@example.com',
            ]);

        User::factory()
            ->create([
                'name' => 'Demo Cashier',
                'email' => 'cashier@example.com',
            ]);
    }
}
