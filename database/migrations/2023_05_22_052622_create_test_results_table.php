<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('test_results', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->references('id')->on('users');
			$table->foreignId('deck_id')->references('id')->on('decks');
			$table->foreignId('testing_series_id')->references('id')->on('testing_series');
			$table->foreignId('opponent_archetype_id')->references('id')->on('archetypes');
			$table->string('result', 16);
			$table->boolean('went_first');
			$table->string('notes')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('test_results');
	}
};
