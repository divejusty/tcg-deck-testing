<?php

namespace Tests\Feature\Services;

use App\Enums\AuditEvent;
use App\Models\Audit;
use App\Models\Set;
use App\Models\User;
use Tests\TestCase;

class AuditServiceTest extends TestCase
{
	private User $user;

	protected function setUp(): void
	{
		parent::setUp();

		$this->user = User::factory()->admin()->create();

		$this->actingAs($this->user);
	}

	public function test_created()
	{
		$this->assertEquals(0, Audit::count());

		Set::factory()->create();

		$this->assertEquals(1, Audit::count());

		$audit = Audit::first();

		$this->assertEquals($this->user->id, $audit->user_id);
		$this->assertEquals(AuditEvent::CREATED, $audit->event);
		$this->assertNull($audit->old_values);
	}

	public function test_updated()
	{
		$set = Set::factory()->createQuietly([ 'name' => 'Scarlet & Violet II' ]);

		$this->assertEquals(0, Audit::count());

		$set->update([ 'name' => 'Paldea Evolved' ]);

		$this->assertEquals(1, Audit::count());

		$audit = Audit::first();

		$this->assertEquals($this->user->id, $audit->user_id);
		$this->assertEquals(AuditEvent::UPDATED, $audit->event);
		$this->assertEquals('Scarlet & Violet II', $audit->old_values['name']);
		$this->assertEquals('Paldea Evolved', $audit->new_values['name']);
	}

	public function test_deleted()
	{
		$set = Set::factory()->createQuietly([ 'name' => 'Scarlet & Violet II' ]);

		$this->assertEquals(0, Audit::count());

		$set->delete();

		$this->assertEquals(1, Audit::count());

		$audit = Audit::first();

		$this->assertEquals($this->user->id, $audit->user_id);
		$this->assertEquals(AuditEvent::DELETED, $audit->event);
		$this->assertNull($audit->new_values);
		$this->assertNull($audit->auditable_id);
	}
}
