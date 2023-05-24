<?php

namespace App\Http\Requests;

use App\Enums\Result;
use App\Models\TestResult;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property TestResult|null $test_result
 * @link TestResult
 */
class TestResultRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return is_null($this->test_result)  ?
			$this->user()->can('update', $this->test_result) :
			$this->user()->can('create', TestResult::class);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, ValidationRule|array|string>
	 */
	public function rules(): array
	{
		$fieldPresence = is_null($this->test_result) ? 'required' : 'sometimes';

		return [
			'deck_id'               => [
				$fieldPresence,
				Rule::exists('decks', 'id')->where('user_id', $this->user()->id),
			],
			'opponent_archetype_id' => [$fieldPresence, 'exists:archetypes,id'],
			'testing_series_id'     => [
				'required',
				Rule::exists('testing_series', 'id')->where('user_id', $this->user()->id),
			],
			'result'                => [ $fieldPresence, Rule::enum(Result::class) ],
			'went_first'            => [ $fieldPresence, 'boolean' ],
		];
	}
}
