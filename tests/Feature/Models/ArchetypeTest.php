<?php

namespace Tests\Feature\Models;

use App\Models\Archetype;
use App\Models\Format;
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

    /**
     * Test the many-to-many relation for formats
     */
    public function test_format_relation(): void
    {
        $archetype = Archetype::factory()
            ->has(Format::factory(5))
            ->create();

        $this->assertEquals(5, $archetype->formats()->count());
    }
}
