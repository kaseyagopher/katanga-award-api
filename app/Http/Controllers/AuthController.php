<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;

class AuthController extends Controller
{
    // Admin login
    public function loginAdmin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('email', $validated['email'])->first();

        if (!$admin || !Hash::check($validated['password'], $admin->password)) {
            return response()->json(['message' => 'Identifiants invalides'], 401);
        }

        $token = $admin->createToken('admin_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'token' => $token,
            'admin' => $admin
        ]);
    }

    public function index(){
        return view('auth.login');
    }

    // User login (numéro seulement)
    public function loginUser(Request $request)
    {
        $validated = $request->validate([
            'numero' => 'required|exists:users,numero',
        ]);

        $user = User::where('numero', $validated['numero'])->first();

        $token = $user->createToken('user_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'token' => $token,
            'user' => $user
        ]);
    }

    // Logout (Admin ou User)
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnexion réussie']);
    }
}
