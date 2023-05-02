<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Request to be used for both storing and updating a Format .
 * @link \App\Models\Format
 */
class FormatRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'required'],
            'is_current' => ['boolean', 'required'],
            'from_set_id' => ['nullable', 'sometimes', 'exists:sets,id'],
            'to_set_id' => ['nullable', 'sometimes', 'exists:sets,id'],
        ];
    }
}
