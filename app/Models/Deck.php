<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Deck
 *
 * @property int $id
 * @property int $user_id
 * @property int $archetype_id
 * @property int $format_id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Archetype $archetype
 * @property-read \App\Models\Format $format
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\DeckFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Deck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deck query()
 * @method static \Illuminate\Database\Eloquent\Builder|Deck whereArchetypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deck whereFormatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deck whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deck whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deck whereUserId($value)
 * @mixin \Eloquent
 */
class Deck extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'format_id',
        'archetype_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function archetype(): BelongsTo
    {
        return $this->belongsTo(Archetype::class);
    }

    public function format(): BelongsTo
    {
        return $this->belongsTo(Format::class);
    }
}
