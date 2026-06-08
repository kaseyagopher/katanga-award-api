<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Candidat;
use App\Models\Categorie;
use App\Models\Edition;
use App\Support\AdminEditionContext;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $editionActive = AdminEditionContext::active();
        $editionViewing = AdminEditionContext::viewing();
        $consultationEdition = AdminEditionContext::consultation();

        $nbCandidats = Candidat::when($editionViewing, fn ($q) => $q->where('edition_id', $editionViewing->id))->count();
        $nbCategories = Categorie::when($editionViewing, fn ($q) => $q->where('edition_id', $editionViewing->id))->count();
        $nbEditions = Edition::count();
        $nbVotes = \App\Models\Vote::when($editionViewing, fn ($q) => $q->where('edition_id', $editionViewing->id))->count();

        $topCandidats = Candidat::with('categorie')
            ->when($editionViewing, fn ($q) => $q->where('edition_id', $editionViewing->id))
            ->withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->take(3)
            ->get();

        $categoriesLabels = [];
        $categoriesVotes = [];

        if ($editionViewing) {
            $categories = Categorie::where('edition_id', $editionViewing->id)
                ->with(['candidats' => function($q) {
                    $q->withCount('votes');
                }])->get();

            foreach ($categories as $categorie) {
                $categoriesLabels[] = $categorie->nom_categorie;
                $votesTotal = $categorie->candidats->sum('votes_count');
                $categoriesVotes[] = $votesTotal;
            }
        }

        $recentVotes = \App\Models\Vote::with(['user','candidat.categorie'])
            ->when($editionViewing, fn ($q) => $q->where('edition_id', $editionViewing->id))
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'editionActive',
            'editionViewing',
            'consultationEdition',
            'nbCandidats',
            'nbCategories',
            'nbEditions',
            'nbVotes',
            'topCandidats',
            'categoriesLabels',
            'categoriesVotes',
            'recentVotes'
        ));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'string', 'min:8'],
            'pseudo' => ['required', 'string', 'max:50', 'unique:admins,pseudo'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $admin = Admin::create($validated);

    }


    public function show(Admin $admin)
    {
        return $admin;
    }


    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:admins,email,' . $admin->id],
            'password' => ['sometimes', 'string', 'min:8'],
            'pseudo' => ['sometimes', 'string', 'max:50', 'unique:admins,pseudo,' . $admin->id],
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $admin->update($validated);


    }


    public function destroy(Admin $admin)
    {
        $admin->delete();
    }
}
