<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultatController extends Controller
{
    public function index()
{
    return view('admin.resultats');
}

public function data()
{
    $edition = \App\Models\Edition::where('statut', 1)->first();

    if (!$edition) {
        return response()->json([]);
    }

    $categories = \App\Models\Categorie::where('edition_id', $edition->id)
        ->with(['candidats' => function($q) {
            $q->withCount('votes');
        }])
        ->get();

    // Transformer les données pour ne retourner que l’essentiel
    $result = $categories->map(function($categorie) {
        return [
            'id' => $categorie->id,
            'nom_categorie' => $categorie->nom_categorie,
            'candidats' => $categorie->candidats->map(function($candidat) {
                return [
                    'id' => $candidat->id,
                    'nom_complet' => $candidat->nom_complet,
                    'votes_count' => $candidat->votes_count ?? 0
                ];
            })
        ];
    });

    return response()->json($result);
}

}
