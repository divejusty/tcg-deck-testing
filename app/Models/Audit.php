<?php

namespace App\Models;

use App\Enums\AuditEvent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Audit
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $auditable_id
 * @property string $auditable_type
 * @property AuditEvent $event
 * @property array|null $old_values
 * @property array|null $new_values
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|\Eloquent $auditable
 * @property-read \App\Models\User|null $user
 * @method static Builder|Audit newModelQuery()
 * @method static Builder|Audit newQuery()
 * @method static Builder|Audit query()
 * @method static Builder|Audit whereAuditableId($value)
 * @method static Builder|Audit whereAuditableType($value)
 * @method static Builder|Audit whereCreatedAt($value)
 * @method static Builder|Audit whereEvent($value)
 * @method static Builder|Audit whereId($value)
 * @method static Builder|Audit whereNewValues($value)
 * @method static Builder|Audit whereOldValues($value)
 * @method static Builder|Audit whereUpdatedAt($value)
 * @method static Builder|Audit whereUserId($value)
 * @mixin \Eloquent
 */
class Audit extends Model
{
	protected $fillable = [
		'user_id',
		'auditable_id',
		'auditable_type',
		'event',
		'old_values',
		'new_values',
	];

	protected $casts = [
		'event'      => AuditEvent::class,
		'old_values' => 'array',
		'new_values' => 'array',
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function auditable(): MorphTo
	{
		return $this->morphTo();
	}
}
