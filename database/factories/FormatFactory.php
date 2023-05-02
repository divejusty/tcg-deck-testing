<?php

namespace Database\Factories;

use App\Models\Format;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Format>
 * @method Format create(?array $attributes = [])
 */
class FormatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'is_current' => true,
        ];
    }
}
