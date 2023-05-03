<?php

namespace Tests\Feature;

use App\Models\Set;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class SetControllerTest extends TestCase
{
    protected User $user;

    public function setup(): void
    {
        parent::setup();

        Set::factory(10)->create();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_index(): void
    {
        $this->get(route('sets.index'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->has('sets', 10)
                ->where('can_create', false)
            );
    }

    public function test_store()
    {
        $postData = [
            'name'         => 'testset',
            'code'         => 'tes',
            'release_date' => now()->format('Y-m-d'),
        ];

        // First test without permissions
        $this->post(route('sets.store'), $postData)
            ->assertForbidden();

        $this->assertEquals(10, Set::count());

        // Now give the user permissions and try again
        $this->user->is_admin = true;
        $this->user->save();

        $this->post(route('sets.store'), $postData)
            ->assertRedirect(route('sets.index'))
            ->assertSessionHas('success', "Successfully created set {$postData['name']}!");

        $this->assertEquals(11, Set::count());
    }

    public function test_store_with_input_error()
    {
        $this->user->is_admin = true;
        $this->user->save();

        $this->post(route('sets.store'))
            ->assertRedirect()
            ->assertSessionHasErrors([ 'name', 'code', 'release_date' ]);
    }

    public function test_update()
    {
        $this->user->is_admin = true;
        $this->user->save();

        $set = Set::factory()->create();
        $newCode = '1ST';

        $this->patch(route('sets.update', [ 'set' => $set->id ]), [
            'name'         => $set->name,
            'code'         => $newCode,
            'release_date' => $set->release_date->format('Y-m-d'),
        ])->assertRedirect(route('sets.index'))
            ->assertSessionHas('success', "Successfully updated set $set->name!");

        $set->refresh();

        $this->assertEquals($newCode, $set->code);
    }

    public function test_destroy()
    {
        $this->delete(route('sets.destroy', [ 'set' => Set::first()->id ]))
            ->assertForbidden();

        $this->assertEquals(10, Set::count());

        $this->user->is_admin = true;
        $this->user->save();

        $set = Set::first();

        $this->delete(route('sets.destroy', [ 'set' => $set->id ]))
            ->assertRedirect(route('sets.index'))
            ->assertSessionHas('success', "Successfully deleted set $set->name!");

        $this->assertEquals(9, Set::count());
    }
}
