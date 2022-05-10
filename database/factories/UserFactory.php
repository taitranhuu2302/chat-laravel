<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

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
    public function definition()
    {
        return [
            'email' => preg_replace('/@example\..*/', '@gmail.com', $this->faker->unique()->safeEmail()),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'avatar' => 'https://picsum.photos/1200/800',
            'full_name' => $this->faker->name(),
        ];
    }

    /**
     * Indicate that the model's mail address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
