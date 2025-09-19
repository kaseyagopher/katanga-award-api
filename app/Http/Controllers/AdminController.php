<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller implements HasMiddleware
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
        // Retourne tous les admins
        $admins = Admin::all();
        return response()->json($admins);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'string', 'min:8'],
            'pseudo' => ['required', 'string', 'max:50', 'unique:admins,pseudo'],
        ]);

        // Hash du mot de passe avant sauvegarde
        $validated['password'] = Hash::make($validated['password']);

        $admin = Admin::create($validated);

        $token = $admin->createToken($request->pseudo);

        return response()->json([
            'message' => 'Admin créé avec succès',
            'admin' => $admin,
            'token' => $token->plainTextToken
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return response()->json($admin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:admins,email,' . $admin->id],
            'password' => ['sometimes', 'string', 'min:8'],
            'pseudo' => ['sometimes', 'string', 'max:50', 'unique:admins,pseudo,' . $admin->id],
        ]);

        // Hash du mot de passe si fourni
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $admin->update($validated);

        return response()->json([
            'message' => 'Admin mis à jour avec succès',
            'admin' => $admin
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();

        return response()->json([
            'message' => 'Admin supprimé avec succès'
        ]);
    }
}
