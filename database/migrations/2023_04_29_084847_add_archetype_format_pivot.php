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
        Schema::create('archetype_format', function (Blueprint $table) {
            $table->foreignId('archetype_id')->references('id')->on('archetypes')->cascadeOnDelete();
            $table->foreignId('format_id')->references('id')->on('formats')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archetype_format');
    }
};
