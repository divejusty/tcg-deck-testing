<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		// Create standard permissions
		$archetypePermission = Permission::create([ 'name' => 'archetypes' ]);
		$formatPermission = Permission::create([ 'name' => 'formats' ]);
		$setPermission = Permission::create([ 'name' => 'sets' ]);
		$userPermission = Permission::create([ 'name' => 'users' ]);

		// Create admin role
		$adminRole = Role::create([ 'name' => 'admin' ]);
		$adminRole->permissions()->sync([
			$archetypePermission->id,
			$formatPermission->id,
			$setPermission->id,
			$userPermission->id,
		]);
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		$roles = Role::all();
		$roles->each(function (Role $role) {
			$role->permissions()->sync([]);
			$role->delete();
		});

		// Cannot run truncate, as it's referenced by a foreign key
		Permission::all()->each->delete();
	}
};
