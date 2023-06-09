<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetRequest;
use App\Http\Resources\SetResource;
use App\Models\Set;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\ResponseFactory;

class SetController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Set::class, 'set');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response|ResponseFactory
    {
        $user = Auth::user();
        return inertia('Sets/SetIndex', [
            'sets'       => SetResource::collection(Set::all())->toArray($request),
            'can_create' => fn () => $user->can('create', Set::class),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SetRequest $request): RedirectResponse
    {
        $set = Set::create($request->validated());

        return to_route('sets.index')->with('success', "Successfully created set $set->name!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Set $set)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SetRequest $request, Set $set): RedirectResponse
    {
        $set->update($request->validated());

        return to_route('sets.index')->with('success', "Successfully updated set $set->name!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Set $set): RedirectResponse
    {
        $set->delete();

        return to_route('sets.index')->with('success', "Successfully deleted set $set->name!");
    }
}
