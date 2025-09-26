<?php

namespace App\Http\Controllers;

use App\Models\Edition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditionController extends Controller 
{
    /**
     * Afficher la liste des éditions (vue Blade).
     */
    public function index()
    {
        $Editions = Edition::all();
        return view('admin.editions', compact('Editions'));
    }

    /**
     * Récupérer une édition en JSON (pour le bouton Modifier).
     */
    public function edit($id)
    {
        $edition = Edition::find($id);

        if(!$edition){
            return response()->json([
                'success' => false,
                'message' => 'Édition non trouvée.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'edition' => $edition
        ]);
    }

    /**
     * Créer une nouvelle édition (AJAX).
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'titre' => ['required', 'string', 'max:255'],
                'theme' => ['required', 'string', 'max:255'],
                'statut' => ['required', 'in:0,1'],
            ]);

            $edition = Edition::create([
                'titre' => $validated['titre'],
                'theme' => $validated['theme'],
                'statut' => $validated['statut'],
                'admin_id' => Auth::guard('admin')->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Édition enregistrée avec succès',
                'edition' => $edition
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur : ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mettre à jour une édition.
     */
    public function update(Request $request, Edition $edition)
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'theme' => ['required', 'string', 'max:255'],
            'statut' => ['required', 'in:0,1'],
        ]);

        $edition->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Édition mise à jour avec succès',
            'edition' => $edition
        ]);
    }

    /**
     * Supprimer une édition.
     */
    public function destroy(Edition $edition)
    {
        $edition->delete();

        return response()->json([
            'success' => true,
            'message' => 'Édition supprimée avec succès'
        ]);
    }
}
