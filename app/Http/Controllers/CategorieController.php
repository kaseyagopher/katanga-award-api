<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retourne toutes les catégories
        $categories = Categorie::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_categorie' => ['required', 'string', 'max:255'],
            'edition_id' => ['required', 'exists:editions,id'],
            'admin_id' => ['required', 'exists:admins,id'],
        ]);

        $categorie = Categorie::create($validated);

        return response()->json([
            'message' => 'Catégorie ajoutée avec succès',
            'categorie' => $categorie
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        return response()->json($categorie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $categorie)
    {
        $validated = $request->validate([
            'nom_categorie' => ['sometimes', 'string', 'max:255'],
            'edition_id' => ['sometimes', 'exists:editions,id'],
            'admin_id' => ['sometimes', 'exists:admins,id'],
        ]);

        $categorie->update($validated);

        return response()->json([
            'message' => 'Catégorie mise à jour avec succès',
            'categorie' => $categorie
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        $categorie->delete();

        return response()->json([
            'message' => 'Catégorie supprimée avec succès'
        ]);
    }
}
