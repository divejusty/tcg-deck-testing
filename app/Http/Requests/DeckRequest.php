<?php

namespace App\Http\Requests;

use App\Models\Deck;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Unified Request class for creating and editing Decks
 * @link Deck
 * @property Deck|null $deck
 */
class DeckRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return is_null($this->deck) ?
			$this->user()->can('create', Deck::class) :
			$this->user()->can('update', $this->deck);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, ValidationRule|array|string>
	 */
	public function rules(): array
	{
		$fieldPresence = is_null($this->deck) ? 'required' : 'sometimes';
		return [
			'name'         => [ $fieldPresence, 'string' ],
			'format_id'    => [ $fieldPresence, 'exists:formats,id' ],
			'archetype_id' => [ $fieldPresence, 'exists:archetypes,id' ],
		];
	}
}
