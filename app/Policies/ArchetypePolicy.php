<?php

namespace App\Policies;

use App\Models\Archetype;
use App\Models\User;

class ArchetypePolicy
{
	/**
	 * Determine whether the user can view any models.
	 */
	public function viewAny(User $user): bool
	{
		return true;
	}

	/**
	 * Determine whether the user can view the model.
	 */
	public function view(User $user, Archetype $archetype): bool
	{
		return true;
	}

	/**
	 * Determine whether the user can create models.
	 */
	public function create(User $user): bool
	{
		return $user->canManage('archetypes');
	}

	/**
	 * Determine whether the user can update the model.
	 */
	public function update(User $user, Archetype $archetype): bool
	{
		return $user->canManage('archetypes');
	}

	/**
	 * Determine whether the user can delete the model.
	 */
	public function delete(User $user, Archetype $archetype): bool
	{
		return $user->canManage('archetypes');
	}
}
