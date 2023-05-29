<?php

namespace App\Observers;

use App\Contracts\Auditable;
use App\Services\AuditService;

readonly class AuditObserver
{
	public function created(Auditable $model): void
	{
		AuditService::created($model, $model->toArray());
	}

	public function updating(Auditable $model): void
	{
		if ($model->isDirty()) {
			$changedValues = $model->getDirty();

			$oldValues = [];

			foreach (array_keys($changedValues) as $key) {
				$oldValues[$key] = $model->getOriginal($key);
			}

			AuditService::updated($model, $oldValues, $changedValues);
		}
	}

	public function deleted(Auditable $model): void
	{
		AuditService::deleted($model, $model->toArray());
	}
}
