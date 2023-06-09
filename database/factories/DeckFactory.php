<?php

namespace Database\Factories;

use App\Models\Archetype;
use App\Models\Deck;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Deck>
 * @method Deck create(?array $attributes = [])
 */
class DeckFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'name'         => $this->faker->name,
			'archetype_id' => Archetype::factory(),
		];
	}
}
