<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Categorie;
use App\Models\Edition;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ColorThief\ColorThief;

class CandidatController extends Controller
{
    /**
     * Liste des candidats.
     */
    public function index()
    {
        $candidats = Candidat::with('categorie', 'edition')->get();
        $Categories = Categorie::all();
        $editions = Edition::all();

        return view('admin.candidats', compact('candidats', 'Categories', 'editions'));
    }

    /**
     * Formulaire de création.
     */
    public function create()
    {
        $Categories = Categorie::all();
        $Editions = Edition::all();

        return view('admin.create-edit-candidat', compact('Categories', 'Editions'));
    }

    /**
     * Formulaire d’édition.
     */
    public function edit($uuid)
    {
        $Candidat = Candidat::where('uuid', $uuid)->firstOrFail();
        $Categories = Categorie::all();
        $Editions = Edition::all();

        return view('admin.create-edit-candidat', compact('Candidat', 'Categories', 'Editions'));
    }

    /**
     * Enregistrer un candidat.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_complet'  => 'required|string|max:255',
            'description'  => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
            'edition_id'   => 'required|exists:editions,id',
            'photo_url'    => 'required|image|mimes:jpg,jpeg,png,gif|max:10000',
        ]);

        $candidat = new Candidat();
        $candidat->uuid = (string) Str::uuid();
        $candidat->nom_complet = $validated['nom_complet'];
        $candidat->description = $validated['description'] ?? null;
        $candidat->categorie_id = $validated['categorie_id'];
        $candidat->edition_id = $validated['edition_id'];

        // Upload et couleurs dominantes
        if ($request->hasFile('photo_url')) {
            $filename = uniqid() . '.' . $request->file('photo_url')->getClientOriginalExtension();
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/images/candidats';

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $request->file('photo_url')->move($uploadPath, $filename);
            $photoPath = 'images/candidats/' . $filename;
            $candidat->photo_url = $photoPath;

            $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $photoPath;

            if (file_exists($fullPath)) {
                try {
                    $color = ColorThief::getColor($fullPath);
                    $candidat->couleur_dominante = sprintf("#%02x%02x%02x", $color[0], $color[1], $color[2]);
                    $candidat->couleur_dominante_sombre = sprintf("#%02x%02x%02x",
                        max(0, $color[0] * 0.7),
                        max(0, $color[1] * 0.7),
                        max(0, $color[2] * 0.7)
                    );
                } catch (\Exception $e) {
                    $candidat->couleur_dominante = '#ffffff';
                    $candidat->couleur_dominante_sombre = '#cccccc';
                }
            }
        }

        $candidat->save();

        return redirect()->route('candidats.index')->with('success', 'Candidat créé avec succès.');
    }

    /**
     * Met à jour un candidat existant.
     */
    public function update(Request $request, $uuid)
    {
        $candidat = Candidat::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'nom_complet'  => 'required|string|max:255',
            'description'  => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
            'edition_id'   => 'required|exists:editions,id',
            'photo_url'    => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:10000',
        ]);

        $candidat->nom_complet = $validated['nom_complet'];
        $candidat->description = $validated['description'] ?? $candidat->description;
        $candidat->categorie_id = $validated['categorie_id'];
        $candidat->edition_id = $validated['edition_id'];

        if ($request->hasFile('photo_url')) {
            if ($candidat->photo_url && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $candidat->photo_url)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $candidat->photo_url);
            }

            $filename = uniqid() . '.' . $request->file('photo_url')->getClientOriginalExtension();
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/images/candidats';

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $request->file('photo_url')->move($uploadPath, $filename);
            $photoPath = 'images/candidats/' . $filename;
            $candidat->photo_url = $photoPath;

            $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $photoPath;
            if (file_exists($fullPath)) {
                try {
                    $color = ColorThief::getColor($fullPath);
                    $candidat->couleur_dominante = sprintf("#%02x%02x%02x", $color[0], $color[1], $color[2]);
                    $candidat->couleur_dominante_sombre = sprintf("#%02x%02x%02x",
                        max(0, $color[0] * 0.7),
                        max(0, $color[1] * 0.7),
                        max(0, $color[2] * 0.7)
                    );
                } catch (\Exception $e) {
                    $candidat->couleur_dominante = '#ffffff';
                    $candidat->couleur_dominante_sombre = '#cccccc';
                }
            }
        }

        $candidat->save();

        return redirect()->route('candidats.index')->with('success', 'Candidat mis à jour avec succès.');
    }

    /**
     * Supprime un candidat.
     */
    public function destroy($uuid)
{
    // Recherche du candidat via UUID
    $candidat = Candidat::where('uuid', $uuid)->firstOrFail();

    // Suppression du fichier image si présent et existant
    if (!empty($candidat->photo_url)) {
        $imagePath = public_path($candidat->photo_url);

        if (file_exists($imagePath)) {
            try {
                unlink($imagePath);
            } catch (\Exception $e) {
                // Si erreur de suppression, on log sans bloquer
                \Log::warning("Impossible de supprimer l'image du candidat UUID {$uuid}: " . $e->getMessage());
            }
        }
    }

    // Suppression du candidat en base de données
    $candidat->delete();

    return redirect()->route('candidats.index')->with('success', 'Candidat supprimé avec succès.');
}
}
