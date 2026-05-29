<?php

namespace App\Http\Controllers;

use App\Models\Edition;
use App\Models\Vote;

class VoteSummaryController extends Controller
{
    public function show()
    {
        $voteIds = session('last_vote_ids', []);
        $paymentReference = session('last_payment_reference');

        if (empty($voteIds) || ! $paymentReference) {
            return redirect()->route('user.vote')->with('error', 'Aucun vote récent à afficher.');
        }

        $votes = Vote::with(['candidat', 'categorie', 'edition'])
            ->whereIn('id', $voteIds)
            ->where('payment_reference', $paymentReference)
            ->get();

        if ($votes->isEmpty()) {
            return redirect()->route('user.vote')->with('error', 'Récapitulatif introuvable.');
        }

        $editionActive = $votes->first()->edition ?? Edition::where('statut', 1)->first();
        $totalPaid = $votes->sum('montant');

        return view('user.vote.summary', compact('votes', 'editionActive', 'paymentReference', 'totalPaid'));
    }
}
