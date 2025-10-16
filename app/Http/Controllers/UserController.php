<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Categorie;
use App\Models\Edition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

    public function user_contact(){
        return view('user.contact');
    }

    public function showCandidat(\App\Models\Candidat $candidat)
{
    
    $edition = \App\Models\Edition::where("statut", 1)->first();

    return view('user.candidat-details', compact('candidat', 'edition'));
}

    public function user_mail(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Initialiser PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Config Gmail SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'synergieup@gmail.com'; // ton Gmail
            $mail->Password   = 'tdqkyfedfjbcrfho'; // mot de passe d'application
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Expéditeur = Gmail (obligatoire pour passer par Google)
            $mail->setFrom('synergieup@gmail.com', $request->nom);

            // Reply-to = email utilisateur (pour pouvoir répondre directement à lui)
            $mail->addReplyTo($request->email, $request->nom);

            // Destinataire
            $mail->addAddress('excellencekatangaagency@gmail.com', 'Katanga Award');

            // Contenu du mail
            $mail->isHTML(true);
            $mail->Subject = '📩 Nouveau message depuis la page Contact - ' . $request->sujet;
            $mail->Body    = "
                <h2>Nouveau message reçu</h2>
                <p><strong>Nom :</strong> {$request->nom}</p>
                <p><strong>Email :</strong> {$request->email}</p>
                <p><strong>Sujet :</strong> {$request->sujet}</p>
                <p><strong>Message :</strong><br>{$request->message}</p>
            ";
            $mail->AltBody = "Nom: {$request->nom}\nEmail: {$request->email}\nSujet: {$request->sujet}\nMessage:\n{$request->message}";

            $mail->send();

            redirect()->route('user.mail');
            return back()->with('success', 'Votre message a été envoyé ✅');
        } catch (Exception $e) {
            return back()->with('error', "Erreur lors de l'envoi du message : {$mail->ErrorInfo}");
        }
    }

    public function publicite(){
        return view('user.publicite');
    }
}
