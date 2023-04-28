<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class StringList implements CastsAttributes
{
    const SEPARATOR = ';';
    
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): array
    {
        if (is_null($value) || strlen($value) === 0) {
            return [];
        }
        
        return explode(self::SEPARATOR, $value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $values, array $attributes): ?string
    {
        if (is_null($values) || count($values) === 0) {
            return null;
        }
        return implode(self::SEPARATOR, $values);
    }
}
