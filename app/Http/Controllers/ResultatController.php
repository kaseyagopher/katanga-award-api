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
    // Récupérer l'édition en cours (ex: une colonne `is_active` ou la dernière édition)
    $edition = \App\Models\Edition::where('is_active', true)->first();

    if (!$edition) {
        return response()->json([]);
    }

    // Charger uniquement les catégories et candidats de l'édition en cours
    $categories = \App\Models\Categorie::where('edition_id', $edition->id)
        ->with(['candidats' => function($q) {
            $q->withCount('votes');
        }])
        ->get();

    return response()->json($categories);
}
}
