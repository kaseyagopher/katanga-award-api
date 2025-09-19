<?php

namespace App\Http\Controllers;

use App\Models\Edition;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class EditionController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return new Middleware('auth:sanctum', except:['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retourne toutes les éditions
        $editions = Edition::all();
        return response()->json($editions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'theme' => ['required', 'string', 'max:255'],
            'annee' => ['required', 'integer'],
            'statut' => ['required', 'string', 'max:50'],
        ]);

        $edition = Edition::create($validated);

        return response()->json([
            'message' => 'Edition ajoutée avec succès',
            'edition' => $edition
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Edition $edition)
    {
        return response()->json($edition);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Edition $edition)
    {
        $validated = $request->validate([
            'titre' => ['sometimes', 'string', 'max:255'],
            'theme' => ['sometimes', 'string', 'max:255'],
            'annee' => ['sometimes', 'integer'],
            'statut' => ['sometimes', 'string', 'max:50'],
        ]);

        $edition->update($validated);

        return response()->json([
            'message' => 'Edition mise à jour avec succès',
            'edition' => $edition
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Edition $edition)
    {
        $edition->delete();

        return response()->json([
            'message' => 'Edition supprimée avec succès'
        ]);
    }
}
