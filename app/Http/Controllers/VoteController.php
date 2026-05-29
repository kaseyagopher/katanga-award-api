<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Edition;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VoteController extends Controller
{
    public function store(Request $request)
    {
        $edition = Edition::where('statut', 1)->first();

        if (! $edition) {
            return redirect()->route('user.index')->with('error', 'Aucune édition active pour le moment.');
        }

        $validated = $request->validate([
            'votes' => 'required|array|min:1',
            'votes.*' => 'required|integer|exists:candidats,id',
            'edition_id' => 'required|exists:editions,id',
        ]);

        if ((int) $validated['edition_id'] !== (int) $edition->id) {
            return back()->with('error', 'Édition invalide.');
        }

        $selections = [];
        $unitPrice = config('vote.price_cdf');

        foreach ($validated['votes'] as $categorieId => $candidatId) {
            $candidat = Candidat::with('categorie')
                ->where('id', $candidatId)
                ->where('categorie_id', $categorieId)
                ->where('edition_id', $edition->id)
                ->first();

            if (! $candidat) {
                return back()->with('error', 'Sélection invalide pour une catégorie.');
            }

            $selections[] = [
                'categorie_id' => (int) $categorieId,
                'candidat_id' => (int) $candidatId,
                'candidat_nom' => $candidat->nom_complet,
                'categorie_nom' => $candidat->categorie->nom_categorie ?? '',
            ];
        }

        $total = count($selections) * $unitPrice;

        session([
            'pending_vote' => [
                'edition_id' => $edition->id,
                'edition_titre' => $edition->titre,
                'selections' => $selections,
                'unit_price' => $unitPrice,
                'total' => $total,
                'currency' => config('vote.currency_label'),
            ],
        ]);

        return redirect()->route('vote.payment');
    }

    public function payment()
    {
        $pending = session('pending_vote');

        if (! $pending) {
            return redirect()->route('user.vote')->with('error', 'Veuillez d\'abord sélectionner vos candidats.');
        }

        return view('user.vote.payment', ['pending' => $pending]);
    }

    public function processPayment(Request $request)
    {
        $pending = session('pending_vote');

        if (! $pending) {
            return redirect()->route('user.vote')->with('error', 'Session expirée. Recommencez votre vote.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:orange_money,airtel_money,vodacom_mpesa,carte',
        ]);

        $paymentReference = 'SIM-' . strtoupper(Str::random(12));
        $voteIds = [];
        $unitPrice = $pending['unit_price'];

        foreach ($pending['selections'] as $selection) {
            $vote = Vote::create([
                'user_id' => null,
                'candidat_id' => $selection['candidat_id'],
                'categorie_id' => $selection['categorie_id'],
                'edition_id' => $pending['edition_id'],
                'montant' => $unitPrice,
                'payment_reference' => $paymentReference,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'completed',
            ]);
            $voteIds[] = $vote->id;
        }

        session()->forget('pending_vote');
        session([
            'last_payment_reference' => $paymentReference,
            'last_vote_ids' => $voteIds,
        ]);

        return redirect()->route('vote.summary')->with('success', 'Paiement simulé avec succès. Merci pour votre vote !');
    }
}
