<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Categorie;
use App\Models\Edition;
use Illuminate\Http\Request;

class CandidatController extends Controller 
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retourne tous les candidats
        $Candidats = Candidat::all();
        return view('admin.candidats', compact('Candidats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'nom_complet' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'categorie_id' => ['required', 'exists:categories,id'],
        'edition_id' => ['required', 'exists:editions,id'],
        'photo_url' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'], // max 2MB
    ]);

    // Gérer l'upload de la photo
    if ($request->hasFile('photo_url')) {
        $photoPath = $request->file('photo_url')->store('candidats', 'public');
    } else {
        $photoPath = null; // Si tu veux mettre une valeur par défaut
    }

    // Créer le candidat
    $candidat = Candidat::create([
        'nom_complet' => $validated['nom_complet'],
        'description' => $validated['description'] ?? null,
        'categorie_id' => $validated['categorie_id'],
        'edition_id' => $validated['edition_id'],
        'photo_url' => $photoPath ? '/storage/' . $photoPath : null,
    ]);

    return to_route('candidats.index')->with('success', 'Candidat créé avec succès');
}


    public function create(){
        $Categories = Categorie::all();
        $Editions = Edition::all();
        return view('admin.create-edit-candidat', compact('Categories', 'Editions'));
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
