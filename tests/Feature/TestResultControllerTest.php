<?php

namespace Tests\Feature;

use App\Enums\Result;
use App\Models\Archetype;
use App\Models\Deck;
use App\Models\TestingSeries;
use App\Models\TestResult;
use App\Models\User;
use Tests\TestCase;

class TestResultControllerTest extends TestCase
{
	private User $user;
	private TestingSeries $testingSeries;
	private string $baseRoute;
	private Deck $deck;
	private Archetype $versusArchetype;

	protected function setUp(): void
	{
		parent::setUp();

		$this->user = User::factory()->create();
		$this->actingAs($this->user);

		$this->testingSeries = TestingSeries::factory()->create([
			'user_id' => $this->user->id,
		]);

		$this->deck = Deck::factory()
			->for($this->testingSeries->format)
			->for($this->user)
			->create();

		$this->versusArchetype = Archetype::factory()->create();

		// Set the initial route to the show route, so we know where we're going back to
		$this->baseRoute = route('testing_series.show', [ 'testing_series' => $this->testingSeries ]);
		$this->get($this->baseRoute);
	}

	public function test_store(): void
	{
		$this->post(route('test_results.store'), [
			'deck_id'               => $this->deck->id,
			'opponent_archetype_id' => $this->versusArchetype->id,
			'testing_series_id'     => $this->testingSeries->id,
			'result'                => Result::WIN->value,
			'went_first'            => false,
		])
			->assertRedirect($this->baseRoute)
			->assertSessionHas('success', 'Successfully added result');
	}

	public function test_update(): void
	{
		$result = TestResult::factory()
			->for($this->user)
			->for($this->deck)
			->for($this->testingSeries)
			->for($this->versusArchetype, 'opponentArchetype')
			->wentSecond()
			->tied()
			->create();

		$this->put(route('test_results.update', [ 'test_result' => $result->id ]), [
			'went_first' => true,
			'result'     => Result::WIN->value,
		])
			->assertRedirect($this->baseRoute)
			->assertSessionHas('success', 'Successfully updated result');

		$result->refresh();
		$this->assertTrue($result->went_first);
		$this->assertEquals(Result::WIN, $result->result);
	}

	public function test_destroy(): void
	{
		$result = TestResult::factory()
			->for($this->user)
			->for($this->deck)
			->for($this->testingSeries)
			->for($this->versusArchetype, 'opponentArchetype')
			->wentSecond()
			->tied()
			->create();

		$this->delete(route('test_results.destroy', [ 'test_result' => $result->id ]))
			->assertRedirect($this->baseRoute)
			->assertSessionHas('success', 'Successfully deleted result');
	}
}
