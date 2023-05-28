<?php

namespace Database\Factories;

use App\Enums\Result;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestResult>
 */
class TestResultFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'went_first' => false,
			'result'     => Result::WIN,
		];
	}

	public function wentSecond(): static
	{
		return $this->state(fn (array $attributes) => [
			'went_first' => false,
		]);
	}

	public function tied(): static
	{
		return $this->state(fn (array $attributes) => [
			'result' => Result::TIE,
		]);
	}

	public function lost(): static
	{
		return $this->state(fn (array $attributes) => [
			'result' => Result::LOSS,
		]);
	}
}
