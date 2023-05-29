<?php

namespace App\Services;

use App\Contracts\Auditable;
use App\Enums\AuditEvent;
use App\Models\Audit;
use Illuminate\Support\Facades\Auth;

class AuditService
{
	public static function created(Auditable $model, ?array $values = null): void
	{
		$model->audit()->create([
			'user_id'    => Auth::user()?->id,
			'event'      => AuditEvent::CREATED,
			'old_values' => null,
			'new_values' => $values,
		]);
	}

	public static function updated(Auditable $model, ?array $old = null, ?array $new = null): void
	{
		$model->audit()->create([
			'user_id'    => Auth::user()?->id,
			'event'      => AuditEvent::UPDATED,
			'old_values' => $old,
			'new_values' => $new,
		]);
	}

	public static function deleted(Auditable $model, ?array $values = null): void
	{
		/** @var Audit $audit */
		$audit = $model->audit()->make([
			'user_id'    => Auth::user()?->id,
			'event'      => AuditEvent::DELETED,
			'old_values' => $values,
			'new_values' => null,
		]);

		// Set auditable id to null, as the resource was deleted
		$audit->auditable_id = null;
		$audit->save();
	}
}
