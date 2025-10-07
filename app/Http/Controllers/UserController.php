<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Categorie;
use App\Models\Edition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Http\Controllers\VoteController;

class UserController extends Controller
{
    // 🔓 Pages publiques
    public function index()
    {
        $Categories = Categorie::all();
        return view('user.index', compact('Categories'));
    }

    public function user_apropos()
    {
        return view('user.apropos');
    }

    public function user_contact()
    {
        return view('user.contact');
    }

    public function showCandidat($id)
    {
        $candidat = Candidat::findOrFail($id);
        return view('user.candidat-details', compact('candidat'));
    }

    public function user_mail(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'synergieup@gmail.com';
            $mail->Password   = 'tdqkyfedfjbcrfho';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('synergieup@gmail.com', $request->nom);
            $mail->addReplyTo($request->email, $request->nom);
            $mail->addAddress('synergieup@gmail.com', 'Katanga Award');

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

            return back()->with('success', 'Votre message a été envoyé ✅');
        } catch (Exception $e) {
            return back()->with('error', "Erreur lors de l'envoi du message : {$mail->ErrorInfo}");
        }
    }

    // 🔒 Pages protégées
    public function vote()
    {
        if (!Auth::check()) {
            return to_route('login');
        }

        $Categories = Categorie::with('Candidats')->get(); 
        $edition = Edition::latest()->first(); 

        return view('user.vote', compact('Categories', 'edition'));
    }

    public function showVoteSummary()
    {
        if (!Auth::check()) {
            return to_route('login');
        }

        return view('user.vote-summary');
    }

    public function user_logout()
    {
        Auth::logout();
        return to_route('login');
    }
}
