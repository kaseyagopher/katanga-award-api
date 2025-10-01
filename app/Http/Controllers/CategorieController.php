<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Edition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Categories = Categorie::all();
        return view('admin.categories', compact('Categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Editions = Edition::where('statut', '1')->get();
        return view('admin.create-edit', compact('Editions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_categorie' => ['required', 'string', 'max:255'],
            'edition_id' => ['required', 'exists:editions,id'],
        ]);

        $categorie = Categorie::create([
            'nom_categorie' => $validated['nom_categorie'],
            'edition_id' => $validated['edition_id'],
            'admin_id' => Auth::guard('admin')->id()
        ]);

        /* return response()->json([
            'message' => 'Catégorie créée avec succès',
            'categorie' => $categorie
        ]);*/

        return to_route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        return response()->json($categorie);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $Categorie = Categorie::findOrFail($id);
        $Editions = Edition::where('statut', '1')->get();

        return view('admin.create-edit', compact('Categorie', 'Editions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id);

        $validated = $request->validate([
            'nom_categorie' => ['required', 'string', 'max:255'],
            'edition_id' => ['required', 'exists:editions,id'],
        ]);

        $categorie->update([
            'nom_categorie' => $validated['nom_categorie'],
            'edition_id' => $validated['edition_id'],
            'admin_id' => Auth::guard('admin')->id()
        ]);

        return to_route('categories.index');
    }



    public function destroy(Categorie $categorie)
    {
        $categorie->delete();

        /* return response()->json([
            'message' => 'Catégorie supprimée avec succès'
        ]);*/

        return to_route('categories.index');
    }
}
