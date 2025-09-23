<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function admin(){
        return view('auth.loginAdmin');
    }
    // Admin login
    public function loginAdmin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('email', $validated['email'])->first();

        if (!$admin || !Hash::check($validated['password'], $admin->password)) {
            return back()->withErrors(['email' => 'Identifiants invalides'])->withInput();
        }

        // Connexion classique via guard admin
        Auth::guard('admin')->loginUsingId($admin->id);
        
        return to_route('admin.index');
    }

    public function index(){
        return view('auth.login');
    }

    // User login (numéro seulement)
   public function loginUser(Request $request)
    {
        // 1️⃣ Validation du numéro
        $validated = $request->validate([
            'telephone' => [
                'required',
                'regex:/^(?:\+243|0)(81|82|83|84|85|89|97|99)\d{7}$/'
            ]
        ], [
            'telephone.regex' => 'Le numéro doit être Vodacom, Orange ou Airtel'
        ]);

        // 2️⃣ Vérifier si l'utilisateur existe
        $user = User::where('numero', $validated['telephone'])->first();

        // 3️⃣ Si l'utilisateur n'existe pas, le créer
        if (!$user) {
            $user = User::create([
                'numero' => $validated['telephone'],
                // tu peux ajouter d'autres champs par défaut ici
            ]);
        }

        // 4️⃣ Connecter l'utilisateur
        Auth::login($user);
        
        // 5️⃣ Rediriger vers la page d'accueil ou dashboard
        return view('auth.status');
    }

    // Logout (Admin ou User)
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->with('success', 'Déconnecté !');
        }

        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('success', 'Déconnecté !');
        }

        return redirect()->route('login');
    }

    public function createAdmin(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6',
            'pseudo' => 'required|string|max:50',
        ]);

        // Création de l'admin
        $admin = Admin::create([
            'email' => $validated['email'],
            'pseudo' => $validated['pseudo'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'Admin créé avec succès !',
            'admin' => $admin
        ]);
    }

}
