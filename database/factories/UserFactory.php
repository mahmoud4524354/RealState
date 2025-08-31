<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92iXUNpkj0rO05byMi.Ye4oKoEa3Ro911C/.og/at2.uheW6/igi', // password
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'photo' => fake()->imageUrl('60', '60'),
            'role' => fake()->randomElement(['admin', 'agent', 'user']),
            'status' => fake()->randomElement(['active', 'inactive']),
            'remember_token' => Str::random(10),
        ];
    }


    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
