<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class VoteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return new Middleware('auth:sanctum', except:['index', 'show']);
    }
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
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'candidat_id' => ['required', 'exists:candidats,id'],
            'categorie_id' => ['required', 'exists:categories,id'],
            'edition_id' => ['required', 'exists:editions,id'],
        ]);

        $vote = Vote::create($validated);

        return response()->json([
            'message' => 'Vote enregistré avec succès',
            'vote' => $vote
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vote $vote)
    {
        return response()->json($vote);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vote $vote)
    {
        $validated = $request->validate([
            'user_id' => ['sometimes', 'exists:users,id'],
            'candidat_id' => ['sometimes', 'exists:candidats,id'],
            'categorie_id' => ['sometimes', 'exists:categories,id'],
            'edition_id' => ['sometimes', 'exists:editions,id'],
        ]);

        $vote->update($validated);

        return response()->json([
            'message' => 'Vote mis à jour avec succès',
            'vote' => $vote
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vote $vote)
    {
        $vote->delete();

        return response()->json([
            'message' => 'Vote supprimé avec succès'
        ]);
    }
}
