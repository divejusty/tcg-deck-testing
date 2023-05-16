<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\TestingSeries
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int $format_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Format $format
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\TestingSeriesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TestingSeries newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestingSeries newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestingSeries query()
 * @method static \Illuminate\Database\Eloquent\Builder|TestingSeries whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestingSeries whereFormatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestingSeries whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestingSeries whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestingSeries whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestingSeries whereUserId($value)
 * @mixin \Eloquent
 */
class TestingSeries extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'format_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function format(): BelongsTo
    {
        return $this->belongsTo(Format::class);
    }
}
