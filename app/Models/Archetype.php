<?php

namespace App\Models;

use App\Casts\StringList;
use Database\Factories\ArchetypeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Archetype
 *
 * @property int $id
 * @property string $name
 * @property array|null $main_pokemon
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static ArchetypeFactory factory($count = null, $state = [])
 * @method static Builder|Archetype newModelQuery()
 * @method static Builder|Archetype newQuery()
 * @method static Builder|Archetype query()
 * @method static Builder|Archetype whereCreatedAt($value)
 * @method static Builder|Archetype whereId($value)
 * @method static Builder|Archetype whereMainPokemon($value)
 * @method static Builder|Archetype whereName($value)
 * @method static Builder|Archetype whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Archetype extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'main_pokemon',
    ];

    protected $casts = [
        'main_pokemon' => StringList::class,
    ];
}
