<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vote;
use App\Models\Edition;

class VoteSummaryController extends Controller
{
    public function show()
    {
        $user = Auth::guard('web')->user();
        $editionActive = Edition::where('statut', true)->first();

        if (!$editionActive) {
            return redirect()->route('user.index')->with('error', 'Pas d\'édition active.');
        }

        // Récupère les votes de l'utilisateur pour l'édition active
        $votes = Vote::with(['candidat', 'categorie'])
                     ->where('user_id', $user->id)
                     ->where('edition_id', $editionActive->id)
                     ->get();

        return view('user.vote.summary', compact('votes', 'editionActive', 'user'));
    }
}
