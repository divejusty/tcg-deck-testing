<?php

namespace Tests\Feature\Models;

use App\Models\Set;
use Tests\TestCase;

class SetTest extends TestCase
{
    /**
     * Test the legal date attribute.
     * @link Set::legalDate()
     */
    public function test_legal_date(): void
    {
        $set = Set::factory()->create();

        $this->assertEquals($set->release_date->addWeeks(3)->toString(), $set->legal_date->toString());
    }
}
