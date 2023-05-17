<?php

namespace Tests\Feature;

use App\Models\Format;
use App\Models\TestingSeries;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class TestingSeriesControllerTest extends TestCase
{
    private User $user;

    public function setup(): void
    {
        parent::setup();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_index(): void
    {
        TestingSeries::factory(7)->for($this->user)->for(Format::factory())->create();

        $this->get(route('testing_series.index'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('TestingSeries/SeriesIndex')
                ->has('series', 7)
                ->has('formats', 1)
            );
    }

    public function test_store(): void
    {
        $format = Format::factory()->create();

        $this->post(route('testing_series.store'), [
            'name'      => 'EUIC testing',
            'format_id' => $format->id,
        ])->assertRedirect(route('testing_series.index'))
            ->assertSessionHas('success', "Successfully created series EUIC testing!");

        $this->assertEquals(1, $this->user->testingSeries()->count());
    }

    public function test_update(): void
    {
        $series = TestingSeries::factory()
            ->for(Format::factory())
            ->for($this->user)
            ->create();

        $this->patch(route('testing_series.update', [ 'testing_series' => $series->id ]), [
            'name' => 'NAIC testing',
        ])->assertRedirect(route('testing_series.index'))
            ->assertSessionHas('success', "Successfully updated series NAIC testing!");

        $series->refresh();

        $this->assertEquals('NAIC testing', $series->name);
    }

    public function test_destroy(): void
    {
        $series = TestingSeries::factory()
            ->for(Format::factory())
            ->for($this->user)
            ->create();

        $this->delete(route('testing_series.destroy', [ 'testing_series' => $series->id ]))
            ->assertRedirect(route('testing_series.index'))
            ->assertSessionHas('success', "Successfully deleted series $series->name!");

        $this->assertEquals(0, $this->user->testingSeries()->count());
    }
}
