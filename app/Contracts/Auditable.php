<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface Auditable
{
	public static function bootIsAudited(): void;
	
	public function audit(): MorphOne;
}
