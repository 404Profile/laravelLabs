<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Interest>
 */
class InterestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->realText(15),
            'type' => fake()->numberBetween(0, 2),
            'description' => fake()->realText(800),
            'user_id' => User::query()->inRandomOrder()->pluck('id')->first(),
        ];
    }
}
