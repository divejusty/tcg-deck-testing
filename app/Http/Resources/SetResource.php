<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();

        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'code'         => $this->code,
            'release_date' => $this->release_date->format('Y-m-d'),
            'can_edit'     => $user->can('update', $this->resource),
            'can_delete'   => $user->can('delete', $this->resource),
        ];
    }
}
