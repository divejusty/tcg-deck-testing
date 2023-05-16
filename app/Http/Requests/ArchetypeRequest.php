<?php

namespace App\Http\Requests;

use App\Models\Archetype;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property Archetype|null $archetype
 */
class ArchetypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return is_null($this->archetype) ?
            $this->user()->can('create', Archetype::class) :
            $this->user()->can('update', $this->archetype);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'           => [
                is_null($this->archetype) ? 'required' : 'sometimes',
                'string',
                is_null($this->archetype) ? 'unique:archetypes' : Rule::unique('archetypes')->ignore($this->archetype),
            ],
            'first_pokemon'  => [ 'nullable', 'string' ],
            'second_pokemon' => [ 'nullable', 'string' ],
        ];
    }
}
