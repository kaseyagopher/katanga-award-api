<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{

    public function index()
    {
        $votes = Vote::all();
        return response()->json($votes);
    }
    public function store(Request $request)
{

    $request->validate([
        'votes' => 'required|array',
        'user_id' => 'required|exists:users,id',
        'edition_id' => 'required|exists:editions,id',
    ]);

    $deviceToken = $request->input('device_token');
    $ip = $request->ip();

    if (!$deviceToken) {
        return response()->json(['error' => 'Aucun identifiant de device.'], 400);
    }

    $deviceTokenHash = hash('sha256', $deviceToken);
    $ipHash = hash('sha256', $ip);

    $exists = Device::where('device_token_hash', $deviceTokenHash)
                    ->orWhere('ip_hash', $ipHash)
                    ->exists();

    if ($exists) {
        return back()->withErrors(['error' => 'Cet appareil a déjà voté. Merci d\'attendre la prochaine édition !']);
    }

    Device::create([
        'device_token_hash' => $deviceTokenHash,
        'ip_hash' => $ipHash,
        'user_agent' => $request->userAgent(),
    ]);

    
    $user_id = $request->user_id;
    $edition_id = $request->edition_id;

    foreach ($request->votes as $categorie_id => $candidat_id) {
        $exists = \App\Models\Vote::where('user_id', $user_id)
            ->where('categorie_id', $categorie_id)
            ->where('edition_id', $edition_id)
            ->exists();

        if (!$exists) {
            \App\Models\Vote::create([
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
