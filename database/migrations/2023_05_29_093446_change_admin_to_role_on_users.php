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
		Schema::create('roles', function (Blueprint $table) {
			$table->id();
			$table->string('name')->unique();
			$table->timestamps();
		});

		Schema::create('permissions', function (Blueprint $table) {
			$table->id();
			$table->string('name')->unique();
			$table->timestamps();
		});

		Schema::create('permission_role', function (Blueprint $table) {
			$table->foreignId('permission_id')->references('id')->on('permissions');
			$table->foreignId('role_id')->references('id')->on('roles');
		});

		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn('is_admin');
			$table->foreignId('role_id')->after('id')->nullable()->references('id')->on('roles');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('users', function (Blueprint $table) {
			$table->dropConstrainedForeignId('role_id');
			$table->boolean('is_admin')->after('name')->default(false);
		});

		Schema::dropIfExists('permission_role');
		Schema::dropIfExists('permissions');
		Schema::dropIfExists('roles');
	}
};
