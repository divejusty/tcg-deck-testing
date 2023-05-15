<?php

namespace App\Http\Resources;

use App\Contracts\Resources\GeneratesFullLists;
use App\Models\Format;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FormatList extends ResourceCollection implements GeneratesFullLists
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
        return static::make(Format::get()
            ->map(fn (Format $format) => [
                'value' => $format->name,
                'key'   => $format->id,
            ]))
            ->toArray($request);
    }
}
