<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PageController;

class AutoInscriptionsController extends Controller
{
    /**
     * Traite la préinscription :
     * - crée un utilisateur (mdp temporaire)
     * - déclenche l'email de vérif (event Registered)
     * - connecte l'utilisateur
     * - redirige vers la notice
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'email'  => ['required', 'email', 'max:255'],
            'prenom' => ['nullable', 'string', 'max:255'],
            'nom'    => ['nullable', 'string', 'max:255'],
        ]);

        $email = strtolower(trim($data['email']));
        $name  = trim(($data['prenom'] ?? '') . ' ' . ($data['nom'] ?? '')) ?: $email;

        // Vérifie si un utilisateur existe déjà avec cet email
        $existing = User::where('email', $email)->first();

        // Cas 1 : existe déjà + pas encore vérifié → renvoyer le mail de vérif
        if ($existing && !$existing->hasVerifiedEmail()) {
            // Relance l'envoi du mail de vérification
            $existing->sendEmailVerificationNotification();

            // Connecte l'utilisateur existant pour l'afficher sur la notice
            Auth::login($existing);

            return redirect()->route('verification.notice')
                ->with('message', 'Un compte existe déjà, un nouveau lien t’a été renvoyé.');
        }

        // Cas 2 : déjà vérifié → message d’erreur explicite
        if ($existing && $existing->hasVerifiedEmail()) {
            return back()->withErrors([
                'email' => 'Cet email est déjà utilisé et vérifié. Essaie de te connecter.',
            ]);
        }

        // Cas 3 : nouvel utilisateur → création normale
        $user = User::create([
            'name'     => $name,
            'email'    => $email,
            'password' => Hash::make(str()->random(40)),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice');
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

        DB::insert(
            'insert into mcd_utilisateurs (id, nom, prenom, code_statut, code_genre) values (:id, :nom, :prenom, :code_statut, :code_genre)
        ',['id' => $id, 'nom' => $nom, 'prenom' => $prenom, 'code_statut' => $code_statut, 'code_genre' => $code_genre]);

        DB::update(
            'update mcd_users set name = :name, password = :password where id = :id', ['name' => $nom, 'password' => $password, 'id' => $id]
        );
        return to_route('home')->with('success', 'Inscription réussie !');
    }

    public function afficher_demandes_abo(){
        return  DB::select('select nom, prenom from mcd_utilisateurs where code_statut=\'A\'');
    }
    
    public function renvoyer_lien_verif_email(Request $request)
    {
        $user = $request->user();

        // 1) Si l'email est déjà vérifié, on décide selon l'existence du profil
        if ($user->hasVerifiedEmail()) {

            $hasProfile = Utilisateur::where('id', $user->id)->exists();          // PK partagée

            return $hasProfile
                ? redirect()->route('home')
                : redirect()->route('inscription')->with('info', 'Termine ton inscription.');
        }

        // 2) Email non vérifié → renvoyer la notif
        $user->sendEmailVerificationNotification();

        return back()->with('message', 'Un nouveau lien de vérification t’a été envoyé.');
    }
}