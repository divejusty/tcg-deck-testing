<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SetUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
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
