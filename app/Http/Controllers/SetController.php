<?php

namespace App\Http\Controllers;

use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
    public function index(): Response|ResponseFactory
    {
        $user = Auth::user();
        return inertia('Sets/SetIndex', [
            'sets' => Set::all()
                ->map(fn(Set $set) => [
                    'id' => $set->id,
                    'name' => $set->name,
                    'code' => $set->code,
                    'release_date' => $set->release_date->format('Y-m-d'),
                    'can_edit' => $user->can('update', $set),
                ]),
            'can_create' => fn() => $user->can('create', Set::class),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string', Rule::unique('sets')],
            'code' => ['required', 'string', Rule::unique('sets'), 'max:8'],
            'release_date' => ['required', 'date'],
        ]);
        
        Set::create($data);
        
        return to_route('sets.index');
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
    public function update(Request $request, Set $set)
    {
        $data = $request->validate([
            'name' => ['required','string', Rule::unique('sets')->ignore($set)],
            'code' => ['required', 'string', Rule::unique('sets')->ignore($set), 'max:8'],
            'release_date' => ['required', 'date'],
        ]);

        $set->update($data);

        return to_route('sets.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Set $set)
    {
        //
    }
}
