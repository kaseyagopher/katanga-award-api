<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;

class VoteAdminController extends Controller
{
    public function index()
{
    $candidats = \App\Models\Candidat::with(['categorie', 'votes.user'])
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
