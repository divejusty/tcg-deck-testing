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

		$this->user = User::factory()->admin()->create();
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
		$this->user->role()->disassociate()->save();

		$this->get(route('archetypes.index'))
			->assertOk()
			->assertInertia(fn (AssertableInertia $page) => $page
				->component('Archetypes/ArchetypeIndex')
				->has('archetypes', 10)
				->where('can_create', false)
				->has('formats')
			);
	}

	public function test_index_as_admin(): void
	{
		$this->get(route('archetypes.index'))
			->assertOk()
			->assertInertia(fn (AssertableInertia $page) => $page
				->component('Archetypes/ArchetypeIndex')
				->where('can_create', true)
				->etc()
			);
	}

	public function test_create_new_model(): void
	{
		$this->post(route('archetypes.store'), [
			'name'           => 'ZoroRoc',
			'first_pokemon'  => 'Zoroark',
			'second_pokemon' => 'Lycanroc',
		])->assertRedirect(route('archetypes.index'))
			->assertSessionHas('success', 'Successfully created archetype ZoroRoc!');

		$this->assertEquals(11, Archetype::count());
		$archetype = Archetype::firstWhere('name', 'ZoroRoc');
		$this->assertCount(2, $archetype->main_pokemon);
		$this->assertEquals('zoroark', $archetype->main_pokemon[0]);
	}

	public function test_update(): void
	{
		$archetype = Archetype::factory()->create([
			'name'         => 'ZoroPod',
			'main_pokemon' => [ 'Zoroark', 'Golisopod' ],
		]);

		$this->put(route('archetypes.update', [ 'archetype' => $archetype->id ]), [
			'name'           => 'ZoroRoc',
			'first_pokemon'  => 'Zoroark',
			'second_pokemon' => 'Lycanroc',
		])->assertRedirect(route('archetypes.index'))
			->assertSessionHas('success', 'Successfully updated archetype ZoroRoc!');

		$archetype->refresh();
		$this->assertEquals('ZoroRoc', $archetype->name);
	}

	public function test_delete(): void
	{
		$archetype = Archetype::first();

		$this->delete(route('archetypes.destroy', [ 'archetype' => $archetype->id ]))
			->assertRedirect(route('archetypes.index'))
			->assertSessionHas('success', "Successfully deleted archetype $archetype->name!");

		$this->assertEquals(9, Archetype::count());
	}
}
