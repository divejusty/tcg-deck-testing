<?php

namespace Tests\Feature;

use App\Models\Archetype;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ArchetypeControllerTest extends TestCase
{
    protected User $user;

    public function setup(): void
    {
        parent::setup();

        Archetype::factory(10)->create();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_requires_authentication()
    {
        // Logout first
        Auth::logout();

        $this->get(route('archetypes.index'))
            ->assertRedirect(route('login'));
    }

    public function test_index(): void
    {
        $this->get(route('archetypes.index'))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Archetypes/ArchetypeIndex')
                ->has('archetypes', 10)
                ->where('can_create', false)
                ->has('formats')
            );
    }

    public function test_index_as_admin(): void
    {
        $this->user->is_admin = true;
        $this->user->save();

        $this->get(route('archetypes.index'))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Archetypes/ArchetypeIndex')
                ->where('can_create', true)
                ->etc()
            );
    }

    public function test_create_new_model(): void
    {
        $this->user->is_admin = true;
        $this->user->save();

        $this->post(route('archetypes.store'), [
            'name' => 'ZoroRoc',
            'first_pokemon' => 'Zoroark',
            'second_pokemon' => 'Lycanroc',
        ])->assertRedirect(route('archetypes.index'));
        
        $this->assertEquals(11, Archetype::count());
        $archetype = Archetype::firstWhere('name', 'ZoroRoc');
        $this->assertCount(2, $archetype->main_pokemon);
        $this->assertEquals('zoroark', $archetype->main_pokemon[0]);
    }
}
