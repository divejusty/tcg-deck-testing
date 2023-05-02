<?php

namespace App\Http\Requests;

use App\Models\Set;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property Set $set
 * @link Set
 */
class SetUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('sets')->ignore($this->set)],
            'code' => ['required', 'string', Rule::unique('sets')->ignore($this->set), 'max:8'],
            'release_date' => ['required', 'date'],
        ];
    }
}
