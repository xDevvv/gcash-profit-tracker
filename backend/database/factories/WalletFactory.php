<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Core\Constants\Wallets;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * The corresponding model.
     *
     * @var class-string<Wallet>
     */
    protected $model = Wallet::class;

    /**
     * Default wallet definitions.
     */
    private const DEFAULT_WALLETS = [
        [
            'code' => Wallets::GCASH,
            'display_name' => 'GCash',
        ],
        [
            'code' => Wallets::MAYA,
            'display_name' => 'Maya',
        ],
        [
            'code' => Wallets::GOTYME,
            'display_name' => 'GoTyme',
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $wallet = fake()->randomElement(self::DEFAULT_WALLETS);

        return [
            'code' => $wallet['code'],
            'display_name' => $wallet['display_name'],
            'is_active' => true,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    public function active(): static
    {
        return $this->state(fn () => [
            'is_active' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }
}
