<?php

namespace App\Http\Resources;

use App\Contracts\Resources\GeneratesFullLists;
use App\Models\Archetype;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArchetypeList extends ResourceCollection implements GeneratesFullLists
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }

    public static function generateKeyValue(Request $request): array
    {
        return static::make(Archetype::get()
            ->map(fn (Archetype $archetype) => [
                'value' => $archetype->name,
                'key'   => $archetype->id,
            ]))
            ->toArray($request);
    }
}
