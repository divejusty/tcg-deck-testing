<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormatRequest;
use App\Http\Resources\FormatResource;
use App\Models\Format;
use App\Models\Set;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\ResponseFactory;

class FormatController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Format::class, 'format');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response|ResponseFactory
    {
        $user = Auth::user();
        return inertia('Formats/FormatIndex', [
            'formats'    => Format::all()->map(fn (Format $format) => FormatResource::make($format)->toArray($request)),
            'can_create' => fn () => $user->can('create', Format::class),
            'sets'       => Set::orderBy('release_date', 'DESC')->select('id', 'name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormatRequest $request): RedirectResponse
    {
        $format = Format::create($request->validated());

        return to_route('formats.index')->with('success', "Successfully created format $format->name!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Format $format)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormatRequest $request, Format $format): RedirectResponse
    {
        $format->update($request->validated());

        return to_route('formats.index')->with('success', "Successfully updated format $format->name!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Format $format): RedirectResponse
    {
        $format->delete();

        return to_route('formats.index')->with('success', "Successfully deleted format $format->name!");
    }
}
