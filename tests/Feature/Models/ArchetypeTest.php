<?php

namespace Tests\Feature\Models;

use App\Models\Archetype;
use Tests\TestCase;

class ArchetypeTest extends TestCase
{
    /**
     * Test getting and setting the list of pokemon used for the archetype
     */
    public function test_pokemon_casting(): void
    {
        $archetype = Archetype::factory()->create();

        $this->assertIsArray($archetype->main_pokemon);

        $archetype->update([
            'main_pokemon' => [],
        ]);

        $this->assertIsArray($archetype->main_pokemon);
        $this->assertCount(0, $archetype->main_pokemon);
    }
}
