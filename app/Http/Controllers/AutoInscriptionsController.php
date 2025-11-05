<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

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
        $data = $request->validate([
            'email'  => ['required', 'email', 'max:255'],
            'prenom' => ['nullable', 'string', 'max:255'],
            'nom'    => ['nullable', 'string', 'max:255'],
        ]);

        $id = $data['id'];
        $nom = strtolower(trim($data['nom']));
        $prenom = strtolower(trim($data['prenom']));
        $code_genre = $data['code_genre'];
        $code_statut = 'A';
        DB::update('update users set name=:');
        DB::insert(
            'insert into utilisateurs (id, nom, prenom, code_genre, code_statut) 
                    values (:id, :nom, :prenom, :code_genre, :code_statut)',
            ['id' => $id, 'nom' => $nom, 'prenom' => $prenom, 'code_genre' => $code_genre, 'code_statut' => $code_statut]
        );
        return redirect()->route('verification.notice');
    }
}
