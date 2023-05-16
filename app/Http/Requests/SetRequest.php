<?php

namespace App\Http\Requests;

use App\Models\Set;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property Set|null $set
 * @link Set
 */
class SetRequest extends FormRequest
{
    public function authorize()
    {
        return is_null($this->set) ?
            $this->user()->can('create', Set::class) :
            $this->user()->can('update', $this->set);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $fieldPresense = is_null($this->set) ? 'required' : 'sometimes';
        $uniqueRule = is_null($this->set) ? Rule::unique('sets') : Rule::unique('sets')->ignore($this->set);
        return [
            'name'         => [ $fieldPresense, 'string', $uniqueRule ],
            'code'         => [ $fieldPresense, 'string', $uniqueRule, 'max:8' ],
            'release_date' => [ $fieldPresense, 'date' ],
        ];
    }
}
