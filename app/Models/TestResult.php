<?php

namespace App\Models;

use App\Enums\Result;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\TestResult
 *
 * @property int $id
 * @property int $user_id
 * @property int $deck_id
 * @property int $testing_series_id
 * @property int $opponent_archetype_id
 * @property Result $result
 * @property bool $went_first
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Deck $deck
 * @property-read \App\Models\Archetype $opponentArchetype
 * @property-read \App\Models\TestingSeries $testingSeries
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\TestResultFactory factory($count = null, $state = [])
 * @method static Builder|TestResult newModelQuery()
 * @method static Builder|TestResult newQuery()
 * @method static Builder|TestResult query()
 * @method static Builder|TestResult whereCreatedAt($value)
 * @method static Builder|TestResult whereDeckId($value)
 * @method static Builder|TestResult whereId($value)
 * @method static Builder|TestResult whereNotes($value)
 * @method static Builder|TestResult whereOpponentArchetypeId($value)
 * @method static Builder|TestResult whereResult($value)
 * @method static Builder|TestResult whereTestingSeriesId($value)
 * @method static Builder|TestResult whereUpdatedAt($value)
 * @method static Builder|TestResult whereUserId($value)
 * @method static Builder|TestResult whereWentFirst($value)
 * @mixin \Eloquent
 */
class TestResult extends Model
{
	use HasFactory;

	protected $fillable = [
		'user_id',
		'deck_id',
		'opponent_archetype_id',
		'testing_series_id',
		'result',
		'went_first',
	];

	protected $casts = [
		'result'     => Result::class,
		'went_first' => 'bool',
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function deck(): BelongsTo
	{
		return $this->belongsTo(Deck::class);
	}

	public function opponentArchetype(): BelongsTo
	{
		return $this->belongsTo(Archetype::class, 'opponent_archetype_id');
	}

	public function testingSeries(): BelongsTo
	{
		return $this->belongsTo(TestingSeries::class, 'testing_series_id');
	}
}
