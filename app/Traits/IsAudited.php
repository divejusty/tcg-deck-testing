<?php

namespace App\Traits;

use App\Contracts\Auditable;
use App\Models\Audit;
use App\Observers\AuditObserver;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Trait providing the default implementations of the Auditable contract
 * @link Auditable
 */
trait IsAudited
{
	public static function bootIsAudited(): void
	{
		static::observe(new AuditObserver());
	}

	public function audit(): MorphOne
	{
		return $this->morphOne(Audit::class, 'auditable');
	}
}
