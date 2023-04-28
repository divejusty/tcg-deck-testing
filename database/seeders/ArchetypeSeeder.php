<?php

namespace Database\Seeders;

use App\Models\Archetype;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArchetypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Archetype::factory()->create([
            'name' => 'Lugia',
            'main_pokemon' => ['Lugia', 'Archeops'],
        ]);
        Archetype::factory()->create([
            'name' => 'Gardevoir',
            'main_pokemon' => ['Gardevoir'],
        ]);
        Archetype::factory()->create([
            'name' => 'Other',
            'main_pokemon' => ['Substitute'],
        ]);
    }
}
