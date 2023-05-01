<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Set
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property Carbon|null $release_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Database\Factories\SetFactory factory($count = null, $state = [])
 * @method static Builder|Set newModelQuery()
 * @method static Builder|Set newQuery()
 * @method static Builder|Set query()
 * @method static Builder|Set whereCode($value)
 * @method static Builder|Set whereCreatedAt($value)
 * @method static Builder|Set whereId($value)
 * @method static Builder|Set whereName($value)
 * @method static Builder|Set whereReleaseDate($value)
 * @method static Builder|Set whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Set extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'release_date'
    ];

    protected $casts = [
        'release_date' => 'datetime',
    ];

    protected function legalDate(): Attribute
    {
        return Attribute::make(get: fn(mixed $value, array $attributes) => Carbon::parse($attributes['release_date'])->addWeeks(3))->shouldCache();
    }
}
