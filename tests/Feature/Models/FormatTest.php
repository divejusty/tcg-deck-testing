<?php

namespace Tests\Feature\Models;

use App\Models\Format;
use App\Models\Set;
use Tests\TestCase;

class FormatTest extends TestCase
{
    /**
     * Basic testcase for testing the set relations
     */
    public function test_set_relations(): void
    {
        $format = Format::factory()
            ->for(Set::factory(), 'setFrom')
            ->for(Set::factory(), 'setTo')
            ->create();

        $this->assertNotNull($format->setFrom);
        $this->assertNotNull($format->setTo);
    }
}
