<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeckResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'      => $this->name,
            'format'    => FormatResource::make($this->format)->toArray($request),
            'archetype' => ArchetypeResource::make($this->archetype)->toArray($request),
        ];
    }
}
