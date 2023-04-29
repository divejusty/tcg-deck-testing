<?php

namespace App\Http\Controllers;

use App\Models\Archetype;
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
        return inertia('Archetypes', [
            'archetypes' => Archetype::all()
        ]);
    }
}
