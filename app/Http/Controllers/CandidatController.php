<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Categorie;
use App\Models\Edition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ColorThief\ColorThief;

class CandidatController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Candidats = Candidat::with('categorie')->get();
        $Categories = Categorie::all();
        return view('admin.candidats', compact('Candidats', 'Categories'));
    }

    public function create()
    {
        $Categories = Categorie::all();
        $Editions = Edition::all();
        return view('admin.create-edit-candidat', compact('Categories', 'Editions'));
    }

    public function edit($id)
    {
        $Candidat = Candidat::find($id);
        $Categories = Categorie::all();
        $Editions = Edition::all();

        if (!$Candidat) {
            return redirect()->route('candidats.index')->with('error', 'Candidat non trouvé.');
        }

        return view('admin.create-edit-candidat', compact('Candidat', 'Categories', 'Editions'));
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
        'photo_url' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:10000'],
    ]);

    $photoPath = null;
    $hex = null;
    $darker = null;

    if ($request->hasFile('photo_url')) {
        // Upload photo
        $path = $request->file('photo_url')->store('candidats', 'public');
        $photoPath = '/storage/' . $path;

        // Extraire couleur dominante en sécurité
        $fullPath = storage_path('app/public/' . $path);
        if (file_exists($fullPath)) {
            try {
                $color = ColorThief::getColor($fullPath);
                $hex = sprintf("#%02x%02x%02x", $color[0], $color[1], $color[2]);
                $darker = sprintf("#%02x%02x%02x",
                    max(0, $color[0] * 0.7),
                    max(0, $color[1] * 0.7),
                    max(0, $color[2] * 0.7)
                );
            } catch (\Exception $e) {
                $hex = '#ffffff';       // couleur par défaut si erreur
                $darker = '#cccccc';    // couleur sombre par défaut
            }
        }
    }

    Candidat::create([
        'nom_complet' => $validated['nom_complet'],
        'description' => $validated['description'] ?? null,
        'categorie_id' => $validated['categorie_id'],
        'edition_id' => $validated['edition_id'],
        'photo_url' => $photoPath,
        'couleur_dominante' => $hex,
        'couleur_dominante_sombre' => $darker,
    ]);

    return redirect()->route('candidats.index')->with('success', 'Candidat créé avec succès');
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidat $candidat)
    {
        $validated = $request->validate([
            'nom_complet' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'categorie_id' => ['sometimes', 'exists:categories,id'],
            'edition_id' => ['sometimes', 'exists:editions,id'],
            'photo_url' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,gif', 'max:10000'],
        ]);

        if ($request->hasFile('photo_url')) {
            // Upload photo
            $path = $request->file('photo_url')->store('candidats', 'public');
            $validated['photo_url'] = '/storage/' . $path;

            // Extraire couleur dominante
            $fullPath = storage_path('app/public/' . $path);
            $color = ColorThief::getColor($fullPath);

            $hex = sprintf("#%02x%02x%02x", $color[0], $color[1], $color[2]);
            $darker = sprintf("#%02x%02x%02x",
                max(0, $color[0] * 0.7),
                max(0, $color[1] * 0.7),
                max(0, $color[2] * 0.7)
            );

            $validated['couleur_dominante'] = $hex;
            $validated['couleur_dominante_sombre'] = $darker;
        }

        $candidat->update($validated);

        return redirect()->route('candidats.index')->with('success', 'Candidat mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidat $candidat)
    {
        $candidat->delete();

        return redirect()->route('candidats.index')->with('success', 'Candidat supprimé avec succès');
    }
}
