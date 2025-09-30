<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller 
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retourne tous les votes
        $votes = Vote::all();
        return response()->json($votes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'votes' => 'required|array',
        'user_id' => 'required|exists:users,id',
        'edition_id' => 'required|exists:editions,id',
    ]);

    

    $user_id = $request->user_id;
    $edition_id = $request->edition_id;

    foreach ($request->votes as $categorie_id => $candidat_id) {
        // Empêcher les doublons : même user, même catégorie, même édition
        $exists = Vote::where('user_id', $user_id)
                      ->where('categorie_id', $categorie_id)
                      ->where('edition_id', $edition_id)
                      ->exists();

        if (!$exists) {
            Vote::create([
                'user_id' => $user_id,
                'edition_id' => $edition_id,
                'categorie_id' => $categorie_id,
                'candidat_id' => $candidat_id,
            ]);
        }
    }

   return redirect()->route('vote.summary')->with('success', 'Vos votes ont été enregistrés !');
}

}
