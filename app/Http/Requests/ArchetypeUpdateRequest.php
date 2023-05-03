<?php

namespace App\Http\Requests;

use App\Models\Archetype;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property Archetype $archetype
 */
class ArchetypeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->archetype);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'           => [ 'required', 'string', Rule::unique('archetypes')->ignore($this->archetype) ],
            'first_pokemon'  => [ 'nullable', 'string' ],
            'second_pokemon' => [ 'nullable', 'string' ],
        ];
    }
}
