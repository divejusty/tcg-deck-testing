<?php

namespace App\Http\Requests;

use App\Models\Archetype;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ArchetypeStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Archetype::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'           => [ 'required', 'string', 'unique:archetypes' ],
            'first_pokemon'  => [ 'nullable', 'string' ],
            'second_pokemon' => [ 'nullable', 'string' ],
        ];
    }
}
