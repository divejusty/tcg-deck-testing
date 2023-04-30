<?php

namespace App\Http\Controllers;

use App\Models\Set;
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
    public function index(): Response|ResponseFactory
    {
        $user = Auth::user();
        return inertia('Sets/SetIndex', [
            'sets' => Set::all()
                ->map(fn(Set $set) => [
                    'name' => $set->name,
                    'code' => $set->code,
                    'release_date' => $set->release_date,
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
            'name' => ['required','string', 'unique:sets'],
            'code' => ['required', 'string', 'unique:sets', 'max:8'],
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
     * Show the form for editing the specified resource.
     */
    public function edit(Set $set)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Set $set)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Set $set)
    {
        //
    }
}
