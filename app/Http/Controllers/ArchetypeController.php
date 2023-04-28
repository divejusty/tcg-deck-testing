<?php

namespace App\Http\Controllers;

use App\Models\Archetype;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class ArchetypeController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia('Archetypes', [
            'archetypes' => Archetype::all()
        ]);
    }
}
