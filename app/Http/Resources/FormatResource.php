<?php

namespace App\Http\Resources;

use App\Contracts\Resources\GeneratesFullLists;
use App\Models\Format;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormatResource extends JsonResource implements GeneratesFullLists
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
            'id'          => $this->id,
            'name'        => $this->name,
            'is_current'  => $this->is_current,
            'from_set_id' => $this->from_set_id,
            'to_set_id'   => $this->to_set_id,
            'can_edit'    => $user->can('update', $this->resource),
            'can_delete'  => $user->can('delete', $this->resource),
        ];
    }

    public static function generateKeyValueList(): ResourceList
    {
        return ResourceList::make(Format::get()
            ->map(fn (Format $format) => [
                'value' => $format->name,
                'key'   => $format->id,
            ]));
    }
}
