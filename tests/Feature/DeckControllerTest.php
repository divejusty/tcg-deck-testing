<?php

namespace Tests\Feature;

use App\Models\Archetype;
use App\Models\Deck;
use App\Models\Format;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class DeckControllerTest extends TestCase
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
        Format::factory(3)->create();
        Archetype::factory(10)->create();
        Deck::factory(6)->for(Archetype::first())->for(Format::first())->for($this->user)->create();

        $this->get(route('decks.index'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Decks/DeckIndex')
                ->has('formats', 3)
                ->has('archetypes', 10)
                ->has('decks', 6)
            );
    }

    public function test_store(): void
    {
        $format = Format::factory()->create();
        $archetype = Archetype::factory()->create();

        $this->post(route('decks.store'), [
            'name'         => 'ZoroPod',
            'archetype_id' => $archetype->id,
            'format_id'    => $format->id,
        ])->assertRedirect(route('decks.index'));

        $this->assertEquals(1, Deck::count());
        $this->assertEquals(1, $this->user->decks()->count());
    }

    public function test_update(): void
    {
        $deck = Deck::factory()
            ->for(Format::factory())
            ->for(Archetype::factory())
            ->for($this->user)
            ->create();

        $newArchetype = Archetype::factory()->create();
        $this->patch(route('decks.update', [ 'deck' => $deck->id ]), [
            'archetype_id' => $newArchetype->id,
        ])->assertRedirect(route('decks.index'));

        $this->assertEquals(1, $newArchetype->decks()->count());
    }

    public function test_destroy(): void
    {
        $deck = Deck::factory()
            ->for(Format::factory())
            ->for(Archetype::factory())
            ->for($this->user)
            ->create();

        $this->delete(route('decks.destroy', [ 'deck' => $deck->id ]))
            ->assertRedirect(route('decks.index'));

        $this->assertEquals(0, $this->user->decks()->count());
    }
}
