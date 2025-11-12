<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AutoInscriptionsController extends Controller
{

    // Préinscription
    public function store(Request $request)
    {
        $data = $request->validate([
            'email'  => ['required', 'email', 'max:255'],
            'prenom' => ['nullable', 'string', 'max:255'],
            'nom'    => ['nullable', 'string', 'max:255'],
        ]);

        $email = strtolower(trim($data['email']));
        $name  = $email;

        $user = User::find_by_email($email);
        $view = redirect()->route('login'); // valeur par défaut

        // Cas 1 : existe déjà + pas encore vérifié
        if ($user && !$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();

            $view = redirect()->route('verification.notice')
                ->with('message', 'Un compte existe déjà, un nouveau lien t’a été renvoyé.');
        }

        // Cas 2 : existe déjà + vérifié + pas encore inscrit => on redirige vers mdp oublié
        elseif ($user && $user->hasVerifiedEmail() && !Utilisateur::existe($user->id)) {
            $view = redirect()->route('password.request')   // 
                ->with('info', 'Ton email est vérifié. Crée ton mot de passe pour terminer ton inscription.');
        }

        // Cas 3 : existe déjà + vérifié + déjà inscrit
        elseif ($user && $user->hasVerifiedEmail() && Utilisateur::existe($user->id)) {
            $view = redirect()->route('login')
                ->with('info', 'Ce compte est déjà actif. Connecte-toi simplement.');
        }

        // Cas 4 : nouvel utilisateur
        else {
            $plain = str()->random(40);                  // mot de passe temporaire
            $user  = User::creer_user($name, $email, $plain);

            event(new Registered($user));                // déclenche l’envoi du mail
            Auth::login($user);                          // connecté, mais bloqué par 'verified'

            $view = redirect()->route('verification.notice');
        }

        return $view;
    }



    public function inscription(Request $request)
    {
        // L'utilisateur est déjà authentifié/validé par email
        // -> Protèger la route avec middleware('auth','verified')

        $data = $request->validate([
            'prenom'   => ['required', 'string', 'max:255'],
            'nom'      => ['required', 'string', 'max:255'],
            'genre'    => ['required', 'in:H,F,I'], // adapter si besoin ou récupérer depuis la bdd directement
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.confirmed' => 'Les deux mots de passe ne correspondent pas.',
            'password.min'       => 'Le mot de passe doit contenir au moins :min caractères.',
        ]);

        $id = $request->user()->id;
        $prenom = strtolower($data['prenom']);
        $nom = strtolower($data['nom']);
        $code_genre = $data['genre'];
        $code_statut = 'A';
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        Utilisateur::abonnement($id, $nom, $prenom, $code_statut, $code_genre);
        User::abonnement($nom, $password, $id);

        return to_route('home')->with('success', 'Inscription réussie !');
    }



    public function renvoyer_lien_verif_email(Request $request)
    {
        $user = $request->user();

        // 1) Si l'email est déjà vérifié, on décide selon l'existence du profil
        if ($user->hasVerifiedEmail()) {

            $return = Utilisateur::has_profile($user->id)
                ? redirect()->route('home')
                : redirect()->route('inscription')->with('info', 'Termine ton inscription.');
        }

        // 2) Email non vérifié → renvoyer la notif
        else {
            $user->sendEmailVerificationNotification();
            $return = back()->with('message', 'Un nouveau lien de vérification t’a été envoyé.');
        }
        return $return;
    }
}
