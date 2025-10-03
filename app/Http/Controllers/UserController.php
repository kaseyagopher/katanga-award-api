<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Categorie;
use App\Models\Edition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Liste tous les utilisateurs
     */
    public function index()
    {
        $Categories = Categorie::all();
        return view('user.index', compact('Categories'));
    }

    public function vote()
    {
        $Categories = Categorie::with('Candidats')->get(); // on charge aussi les candidats
        $edition = Edition::latest()->first(); // par exemple l'édition active

        return view('user.vote', compact('Categories', 'edition'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['nullable', 'string', 'max:255'],
            'numero'   => ['required', 'string', 'max:20', 'unique:users,numero'],
            'email'    => ['nullable', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name'     => $validated['name'] ?? null,
            'numero'   => $validated['numero'],
            'email'    => $validated['email'] ?? null,
            'password' => isset($validated['password']) ? Hash::make($validated['password']) : null,
        ]);

        $token = $user->createToken($user->numero);


        return response()->json([
            'message' => 'Utilisateur créé avec succès',
            'user'    => $user,
            'token' => $token->plainTextToken
        ], 201);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['sometimes', 'string', 'max:255'],
            'numero'   => ['sometimes', 'string', 'max:20', 'unique:users,numero,' . $user->id],
            'email'    => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['sometimes', 'string', 'min:8'],
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Utilisateur mis à jour avec succès',
            'user'    => $user,
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Utilisateur supprimé avec succès']);
    }


    public function user_apropos(){
        return view('user.apropos');
    }

}
