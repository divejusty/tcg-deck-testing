<?php

namespace App\Http\Requests;

use App\Models\TestingSeries;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property TestingSeries $testing_series
 */
class TestingSeriesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return is_null($this->testing_series) ?
            $this->user()->can('create', TestingSeries::class) :
            $this->user()->can('update', $this->testing_series);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $fieldPresense = is_null($this->testing_series) ? 'required' : 'sometimes';
        return [
            'name'      => [ $fieldPresense, 'string' ],
            'format_id' => [ $fieldPresense, 'exists:formats,id' ],
        ];
    }
}