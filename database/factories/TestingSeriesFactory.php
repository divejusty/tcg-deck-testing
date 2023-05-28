<?php

namespace Database\Factories;

use App\Models\Format;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestingSeries>
 */
class TestingSeriesFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'name'      => fake()->name,
			'format_id' => Format::factory(),
			'active'    => true,
		];
	}

	public function inactive(): TestingSeriesFactory
	{
		return $this->state(fn (array $attributes) => [
			'active' => false,
		]);
	}
}
