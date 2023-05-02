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
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->has('sets', 10)
                ->where('can_create', false)
            );
    }

    public function test_store()
    {
        $postData = [
            'name' => 'testset',
            'code' => 'tes',
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
            ->assertRedirect(route('sets.index'));

        $this->assertEquals(11, Set::count());
    }
}
