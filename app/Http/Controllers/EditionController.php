<?php

namespace App\Http\Controllers;

use App\Models\Edition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditionController extends Controller 
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Editions = Edition::all();
        return view('admin.editions', compact('Editions'));
    }

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

    public function store(Request $request)
    {
        

        try {
            $validated = $request->validate([
                'titre' => ['required', 'string', 'max:255'],
                'theme' => ['required', 'string', 'max:255'],
                'statut' => ['required', 'string', 'max:50'],
            ]);

            $edition = Edition::create([
                'titre' => $validated['titre'],
                'theme' => $validated['theme'],
                'statut' => $validated['statut'],
                'admin_id' => Auth::guard('admin')->id(),       // Récupère l'id de l'utilisateur connecté
            ]);
            
            
            return response()->json([
                'success' => true,
                'message' => 'Édition enregistrée avec succès',
                'edition' => $edition
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Retourne les erreurs de validation en JSON
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur : ' . $e->getMessage(),
                'trace' => $e->getTraceAsString(), // facultatif pour debug
            ], 500);
        }
    }

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
            'statut' => ['sometimes'],
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
