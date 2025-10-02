<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Categorie;
use App\Models\Edition;
use Illuminate\Http\Request;
use ColorThief\ColorThief;

class CandidatController extends Controller
{
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
            // 🔹 Déplacer directement dans /public/images/candidats
            $filename = uniqid() . '.' . $request->file('photo_url')->getClientOriginalExtension();
            $request->file('photo_url')->move(public_path('images/candidats'), $filename);

            $photoPath = 'images/candidats/' . $filename;

            // Extraire couleur dominante
            $fullPath = public_path($photoPath);
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
                    $hex = '#ffffff';
                    $darker = '#cccccc';
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
            // 🔹 Supprimer l’ancienne photo si elle existe
            if ($candidat->photo_url && file_exists(public_path($candidat->photo_url))) {
                unlink(public_path($candidat->photo_url));
            }

            // 🔹 Upload de la nouvelle
            $filename = uniqid() . '.' . $request->file('photo_url')->getClientOriginalExtension();
            $request->file('photo_url')->move(public_path('images/candidats'), $filename);

            $validated['photo_url'] = 'images/candidats/' . $filename;

            // Extraire couleur dominante
            $fullPath = public_path($validated['photo_url']);
            if (file_exists($fullPath)) {
                try {
                    $color = ColorThief::getColor($fullPath);
                    $validated['couleur_dominante'] = sprintf("#%02x%02x%02x", $color[0], $color[1], $color[2]);
                    $validated['couleur_dominante_sombre'] = sprintf("#%02x%02x%02x",
                        max(0, $color[0] * 0.7),
                        max(0, $color[1] * 0.7),
                        max(0, $color[2] * 0.7)
                    );
                } catch (\Exception $e) {
                    $validated['couleur_dominante'] = '#ffffff';
                    $validated['couleur_dominante_sombre'] = '#cccccc';
                }
            }
        }

        $candidat->update($validated);

        return redirect()->route('candidats.index')->with('success', 'Candidat mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidat $candidat)
    {
        // 🔹 Supprimer aussi l’image du dossier
        if ($candidat->photo_url && file_exists(public_path($candidat->photo_url))) {
            unlink(public_path($candidat->photo_url));
        }

        $candidat->delete();

        return redirect()->route('candidats.index')->with('success', 'Candidat supprimé avec succès');
    }
}
