<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormatRequest;
use App\Models\Format;
use App\Models\Set;
use Illuminate\Support\Facades\Auth;

class FormatController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Format::class, 'format');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return inertia('Formats/FormatIndex', [
            'formats' => Format::all()
                ->map(fn(Format $format) => [
                    'id' => $format->id,
                    'name' => $format->name,
                    'is_current' => $format->is_current,
                    'from_set_id' => $format->from_set_id,
                    'to_set_id' => $format->to_set_id,
                    'can_edit' => $user->can('update', $format),
                ]),
            'can_create' => fn() => $user->can('create', Format::class),
            'sets' => Set::orderBy('release_date', 'DESC')->select('id', 'name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormatRequest $request)
    {
        Format::create($request->validated());
        
        return to_route('formats.index');
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
    public function update(FormatRequest $request, Format $format)
    {
        $format->update($request->validated());
        
        return to_route('formats.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Format $format)
    {
        //
    }
}
