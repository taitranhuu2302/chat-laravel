<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $fake_id = 1;
        return [
            'avatar' => 'https://picsum.photos/1200/800',
            'full_name' => $this->faker->name(),
            'user_id' => $fake_id++,
        ];
    }
}
