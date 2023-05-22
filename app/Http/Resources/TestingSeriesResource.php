<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestingSeriesResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'         => $this->id,
			'name'       => $this->name,
			'active'     => $this->active,
			'format'     => FormatResource::make($this->format)->toArray($request),
			'can_edit'   => $request->user()->can('update', $this->resource),
			'can_delete' => $request->user()->can('delete', $this->resource),
		];
	}
}
