<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\FeeRule;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FeeRule>
 */
class FeeRuleFactory extends Factory
{
    /**
     * @var class-string<FeeRule>
     */
    protected $model = FeeRule::class;

    /**
     * Default fee rule.
     *
     * @return array<string,mixed>
     */
    public function definition(): array
    {
        return [

            'wallet_id' => Wallet::factory(),

            'minimum_amount' => 100,

            'maximum_amount' => 200,

            'fee' => 3,

            'priority' => 1,

            'is_active' => true,

            'effective_from' => now(),

            'effective_until' => null,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    public function inactive(): static
    {
        return $this->state(fn () => [

            'is_active' => false,

        ]);
    }

    public function priority(int $priority): static
    {
        return $this->state(fn () => [

            'priority' => $priority,

        ]);
    }

    public function range(
        int $minimum,
        int $maximum,
        int $fee
    ): static {

        return $this->state(fn () => [

            'minimum_amount' => $minimum,

            'maximum_amount' => $maximum,

            'fee' => $fee,

        ]);
    }
}
