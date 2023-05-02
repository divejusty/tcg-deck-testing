<?php

namespace Tests\Feature;

use App\Models\Format;
use App\Models\Set;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class FormatControllerTest extends TestCase
{
    protected User $user;

    public function setup(): void
    {
        parent::setup();

        Format::factory(10)->create();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_index(): void
    {
        $this->get(route('formats.index'))
            ->assertOk()
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->has('formats', 10)
                ->where('can_create', false)
                ->has('sets')
            );
    }

    public function test_store()
    {
        $postData = [
            'name' => 'testformat',
            'is_current' => false,
        ];

        // First test without permissions
        $this->post(route('formats.store'), $postData)
            ->assertForbidden();

        $this->assertEquals(10, Format::count());

        // Now give the user permissions and try again
        $this->user->is_admin = true;
        $this->user->save();

        $this->post(route('formats.store'), $postData)
            ->assertRedirect(route('formats.index'));

        $this->assertEquals(11, Format::count());
    }

    public function test_store_with_input_error()
    {
        $this->user->is_admin = true;
        $this->user->save();

        $this->post(route('formats.store'))
            ->assertRedirect()
            ->assertSessionHasErrors(['name', 'is_current']);
    }

    public function test_store_with_sets()
    {
        $this->user->is_admin = true;
        $this->user->save();

        $setFrom = Set::factory()->create();
        $setTo = Set::factory()->create();

        $this->post(route('formats.store'), [
            'name' => 'testformat',
            'is_current' => true,
            'from_set_id' => $setFrom->id,
            'to_set_id' => $setTo->id,
        ])->assertRedirect(route('formats.index'))->assertSessionHasNoErrors();

        /** @var Format $format */
        $format = Format::orderByDesc('id')->first();

        $this->assertEquals($setFrom->id, $format->from_set_id);
        $this->assertEquals($setTo->id, $format->to_set_id);
    }

    public function test_update()
    {
        $this->user->is_admin = true;
        $this->user->save();

        $format = Format::factory()->create();

        $this->patch(route('formats.update', ['format' => $format->id]), [
            'name' => $format->name,
            'is_current' => false,
        ])->assertRedirect(route('formats.index'));

        $format->refresh();

        $this->assertFalse($format->is_current);
    }
}
