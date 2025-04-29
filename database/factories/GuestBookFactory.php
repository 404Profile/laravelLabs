<?php

namespace Database\Factories;

use App\Models\GuestBook;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuestBookFactory extends Factory
{
    protected $model = GuestBook::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->paragraphs(3, true),
            'author_name' => $this->faker->name(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
