<?php

namespace App\Models;

use App\Casts\StringList;
use App\Contracts\Auditable;
use App\Traits\IsAudited;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Archetype
 *
 * @property int $id
 * @property string $name
 * @property array|null $main_pokemon
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Audit|null $audit
 * @property-read Collection<int, \App\Models\Deck> $decks
 * @property-read int|null $decks_count
 * @property-read Collection<int, \App\Models\Format> $formats
 * @property-read int|null $formats_count
 * @method static \Database\Factories\ArchetypeFactory factory($count = null, $state = [])
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
class Archetype extends Model implements Auditable
{
	use HasFactory;
	use IsAudited;

	protected $fillable = [
		'name',
		'main_pokemon',
	];

	protected $casts = [
		'main_pokemon' => StringList::class,
	];

	public function formats(): BelongsToMany
	{
		return $this->belongsToMany(Format::class);
	}

	public function decks(): HasMany
	{
		return $this->hasMany(Deck::class);
	}
}
