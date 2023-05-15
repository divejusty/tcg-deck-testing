<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArchetypeStoreRequest;
use App\Http\Requests\ArchetypeUpdateRequest;
use App\Http\Resources\ArchetypeResource;
use App\Models\Archetype;
use App\Models\Format;
use Illuminate\Http\RedirectResponse;
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

    public function index(Request $request): Response|ResponseFactory
    {
        $user = Auth::user();
        return inertia('Archetypes/ArchetypeIndex', [
            'archetypes' => ArchetypeResource::collection(Archetype::all())->toArray($request),
            'can_create' => fn () => $user->can('create', Archetype::class),
            'formats'    => fn () => Format::all(),
        ]);
    }

    public function store(ArchetypeStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $mainPokemon = $this->formatPokemonData($data);

        Archetype::create([
            'name'         => $data['name'],
            'main_pokemon' => $mainPokemon,
        ]);

        return to_route('archetypes.index')->with('success', "Successfully created archetype {$data['name']}!");
    }

    public function update(ArchetypeUpdateRequest $request, Archetype $archetype): RedirectResponse
    {
        $data = $request->validated();

        $mainPokemon = $this->formatPokemonData($data);

        $archetype->update([
            'name'         => $data['name'],
            'main_pokemon' => $mainPokemon,
        ]);

        return to_route('archetypes.index')->with('success', "Successfully updated archetype $archetype->name!");
    }

    private function formatPokemonData(array $data): array
    {
        $mainPokemon = [];
        if (!is_null($data['first_pokemon']) && strlen($data['first_pokemon'])) {
            $mainPokemon[] = strtolower($data['first_pokemon']);
        }
        if (!is_null($data['second_pokemon']) && strlen($data['second_pokemon'])) {
            $mainPokemon[] = strtolower($data['second_pokemon']);
        }
        return $mainPokemon;
    }

    public function destroy(Archetype $archetype): RedirectResponse
    {
        $archetype->delete();

        return to_route('archetypes.index')->with('success', "Successfully deleted archetype $archetype->name!");
    }
}
