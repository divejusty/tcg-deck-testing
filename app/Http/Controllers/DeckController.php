<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeckRequest;
use App\Http\Resources\ArchetypeResource;
use App\Http\Resources\DeckResource;
use App\Http\Resources\FormatResource;
use App\Models\Deck;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class DeckController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Deck::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response|ResponseFactory
    {
        $user = $request->user();
        $decks = $user->decks()->with([ 'format', 'archetype' ])->get();

        return inertia('Decks/DeckIndex', [
            'decks'      => DeckResource::collection($decks)->toArray($request),
            'archetypes' => ArchetypeResource::generateKeyValueList()->toArray($request),
            'formats'    => FormatResource::generateKeyValueList()->toArray($request),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeckRequest $request): RedirectResponse
    {
        $deck = $request->user()->decks()->create($request->validated());

        return to_route('decks.index')->with('success', "Successfully created deck $deck->name");
    }

    /**
     * Display the specified resource.
     */
    public function show(Deck $deck)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DeckRequest $request, Deck $deck): RedirectResponse
    {
        $deck->update($request->validated());

        return to_route('decks.index')->with('success', "Successfully updated deck $deck->name");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deck $deck): RedirectResponse
    {
        $deck->delete();

        return to_route('decks.index')->with('success', "Successfully deleted deck $deck->name");
    }
}
