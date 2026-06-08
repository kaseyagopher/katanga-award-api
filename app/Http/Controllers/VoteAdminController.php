<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Support\AdminEditionContext;
use Illuminate\Http\Request;

class VoteAdminController extends Controller
{
    public function index()
{
    $editionViewing = AdminEditionContext::viewing();
    $candidats = \App\Models\Candidat::with(['categorie', 'votes.user'])
        ->when($editionViewing, fn ($q) => $q->where('edition_id', $editionViewing->id))
        ->withCount('votes')
        ->get();

        return view('admin.gestions-votes', compact('candidats'));
    }

    public function destroy($id)
    {
        $vote = Vote::findOrFail($id);
        $vote->delete();
        return back()->with('success', 'Vote supprimé avec succès.');
    }
}
