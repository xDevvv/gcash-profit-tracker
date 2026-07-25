<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Core\Enums\Role;
use App\Core\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The corresponding model.
     *
     * @var class-string<User>
     */
    protected $model = User::class;

    /**
     * Shared password instance.
     */
    protected static ?string $password = null;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password
                ??= Hash::make('password'),
            'remember_token'    => fake()->regexify('[A-Za-z0-9]{10}'),
            'role'              => Role::USER,
            'status'            => UserStatus::ACTIVE,
            'last_login_at'     => now(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    public function admin(): static
    {
        return $this->state(fn () => [
            'role' => Role::ADMIN,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'status' => UserStatus::INACTIVE,
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn () => [
            'email_verified_at' => null,
        ]);
    }

    public function verified(): static
    {
        return $this->state(fn () => [
            'email_verified_at' => now(),
        ]);
    }
}
