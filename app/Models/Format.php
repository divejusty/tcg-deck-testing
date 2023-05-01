<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Format
 *
 * @property int $id
 * @property int|null $from_set_id
 * @property int|null $to_set_id
 * @property string $name
 * @property bool $is_current
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Archetype> $archetypes
 * @property-read int|null $archetypes_count
 * @property-read \App\Models\Set|null $setFrom
 * @property-read \App\Models\Set|null $setTo
 * @method static \Database\Factories\FormatFactory factory($count = null, $state = [])
 * @method static Builder|Format newModelQuery()
 * @method static Builder|Format newQuery()
 * @method static Builder|Format query()
 * @method static Builder|Format whereCreatedAt($value)
 * @method static Builder|Format whereFromSetId($value)
 * @method static Builder|Format whereId($value)
 * @method static Builder|Format whereIsCurrent($value)
 * @method static Builder|Format whereName($value)
 * @method static Builder|Format whereToSetId($value)
 * @method static Builder|Format whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Format extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_current',
        'from_set_id',
        'to_set_id',
    ];

    protected $casts = [
        'is_current' => 'boolean',
    ];

    public function setFrom(): BelongsTo
    {
        return $this->belongsTo(Set::class, 'from_set_id', 'id');
    }

    public function setTo(): BelongsTo
    {
        return $this->belongsTo(Set::class, 'to_set_id', 'id');
    }

    public function archetypes(): BelongsToMany
    {
        return $this->belongsToMany(Archetype::class);
    }
}
