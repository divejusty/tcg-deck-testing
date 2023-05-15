<?php

namespace App\Http\Resources;

use App\Contracts\Resources\GeneratesFullLists;
use App\Models\Archetype;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArchetypeResource extends JsonResource implements GeneratesFullLists
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
            'main_pokemon' => $this->main_pokemon,
            'can_edit'     => $user->can('update', $this->resource),
            'can_delete'   => $user->can('delete', $this->resource),
        ];
    }

    public static function generateKeyValueList(): ResourceList
    {
        return ResourceList::make(Archetype::get()
            ->map(fn (Archetype $archetype) => [
                'value' => $archetype->name,
                'key'   => $archetype->id,
            ]));
    }
}
