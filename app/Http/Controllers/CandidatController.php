<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Http\Request;

class CandidatController extends Controller 
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retourne tous les candidats
        $candidats = Candidat::all();
        return response()->json($candidats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_complet' => ['required', 'string', 'max:255'],
            'photo_url' => ['nullable', 'string', 'url'], 
            'description' => ['nullable', 'string'],
            'categorie_id' => ['required', 'exists:categories,id'],
            'edition_id' => ['required', 'exists:editions,id'],
        ]);

        $candidat = Candidat::create($validated);

        return response()->json([
            'message' => 'Candidat ajouté avec succès',
            'candidat' => $candidat
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidat $candidat)
    {
        return response()->json($candidat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidat $candidat)
    {
        $validated = $request->validate([
            'nom_complet' => ['sometimes', 'string', 'max:255'],
            'photo_url' => ['sometimes', 'string', 'url'],
            'description' => ['sometimes', 'string'],
            'categorie_id' => ['sometimes', 'exists:categories,id'],
            'edition_id' => ['sometimes', 'exists:editions,id'],
        ]);

        $candidat->update($validated);

        return response()->json([
            'message' => 'Candidat mis à jour avec succès',
            'candidat' => $candidat
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidat $candidat)
    {
        $candidat->delete();

        return response()->json([
            'message' => 'Candidat supprimé avec succès'
        ]);
    }
}
