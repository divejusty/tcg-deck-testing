<?php

namespace App\Http\Controllers;

use App\Models\Archetype;
use App\Models\Format;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\ResponseFactory;

class ArchetypeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Archetype::class, 'archetype');
    }

    public function index(): Response|ResponseFactory
    {
        $user = Auth::user();
        return inertia('Archetypes/ArchetypeIndex', [
            'archetypes' => Archetype::all()
                ->map(fn(Archetype $archetype) => [
                    'name' => $archetype->name,
                    'main_pokemon' => $archetype->main_pokemon,
                    'can_edit' => $user->can('update', $archetype),
                ]),
            'can_create' => fn() => $user->can('create', Archetype::class),
            'formats' => fn() => Format::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string', 'unique:archetypes'],
            'first_pokemon' => ['nullable', 'string'],
            'second_pokemon' => ['nullable', 'string'],
        ]);

        $mainPokemon = [];
        if (!is_null($data['first_pokemon']) && strlen($data['first_pokemon'])) {
            $mainPokemon[] = strtolower($data['first_pokemon']);
        }
        if (!is_null($data['second_pokemon']) && strlen($data['second_pokemon'])) {
            $mainPokemon[] = strtolower($data['second_pokemon']);
        }

        Archetype::create([
            'name' => $data['name'],
            'main_pokemon' => $mainPokemon,
        ]);

        return to_route('archetypes.index');
    }
}
