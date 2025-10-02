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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_complet' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
            'edition_id' => 'required|exists:editions,id',
            'photo_url' => 'required|image|mimes:jpg,jpeg,png,gif|max:10000',
        ]);

        $photoPath = null;
        $hex = '#ffffff';
        $darker = '#cccccc';

        if ($request->hasFile('photo_url')) {
            $filename = uniqid() . '.' . $request->file('photo_url')->getClientOriginalExtension();

            // Upload dans public_html/images/candidats
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/images/candidats';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $request->file('photo_url')->move($uploadPath, $filename);
            $photoPath = 'images/candidats/' . $filename;

            // Extraire couleur dominante
            $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $photoPath;
            if (file_exists($fullPath)) {
                try {
                    $color = ColorThief::getColor($fullPath);
                    $hex = sprintf("#%02x%02x%02x", $color[0], $color[1], $color[2]);
                    $darker = sprintf("#%02x%02x%02x",
                        max(0, $color[0] * 0.7),
                        max(0, $color[1] * 0.7),
                        max(0, $color[2] * 0.7)
                    );
                } catch (\Exception $e) {}
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

    public function update(Request $request, Candidat $candidat)
    {
        $validated = $request->validate([
            'nom_complet' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'categorie_id' => 'sometimes|exists:categories,id',
            'edition_id' => 'sometimes|exists:editions,id',
            'photo_url' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:10000',
        ]);

        if ($request->hasFile('photo_url')) {
            // Supprimer ancienne image
            if ($candidat->photo_url && file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$candidat->photo_url)) {
                unlink($_SERVER['DOCUMENT_ROOT'].'/'.$candidat->photo_url);
            }

            $filename = uniqid() . '.' . $request->file('photo_url')->getClientOriginalExtension();
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/images/candidats';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $request->file('photo_url')->move($uploadPath, $filename);
            $validated['photo_url'] = 'images/candidats/' . $filename;

            // Couleur dominante
            $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $validated['photo_url'];
            if (file_exists($fullPath)) {
                try {
                    $color = ColorThief::getColor($fullPath);
                    $validated['couleur_dominante'] = sprintf("#%02x%02x%02x", $color[0], $color[1], $color[2]);
                    $validated['couleur_dominante_sombre'] = sprintf("#%02x%02x%02x",
                        max(0, $color[0] * 0.7),
                        max(0, $color[1] * 0.7),
                        max(0, $color[2] * 0.7)
                    );
                } catch (\Exception $e) {}
            }
        }

        $candidat->update($validated);

        return redirect()->route('candidats.index')->with('success', 'Candidat mis à jour avec succès');
    }

    public function destroy(Candidat $candidat)
    {
        if ($candidat->photo_url && file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$candidat->photo_url)) {
            unlink($_SERVER['DOCUMENT_ROOT'].'/'.$candidat->photo_url);
        }

        $candidat->delete();

        return redirect()->route('candidats.index')->with('success', 'Candidat supprimé avec succès');
    }
}
