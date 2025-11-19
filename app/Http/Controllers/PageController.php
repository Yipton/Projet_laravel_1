<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\Utilisateur;

class PageController extends Controller
{
    public function home(): View
    {
        $user = Auth::user();
        return view('accueil', ['user' => $user]);
    }

    public function mentions(): View
    {
        return view('mentions');
    }

    public function email_verification(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route('inscription');
    }

    public function inscription(): View
    {
        return view('auth.inscription');
    }
    public function create(): View
    {
        return view('preinscription');
    }

    public function lien_verif_email_envoye()
    {
        return view('auth.lien_envoye');
    }

    public function eleves(): View
    {
        return view('colleges.eleves');
    }
    public function equipe(): View
    {
        return view('colleges.equipe');
    }
    public function epreuves(): View
    {
        return view('epreuves');
    }

    public function classement(): View
    {
        return view('classement');
    }
    public function show2024(): View
    {
        return view('edition.2024');
    }
    public function show2025(): View
    {
        return view('edition.2025');
    }

    public function saisie_note(): View
    {
        return view('saisie-note');
    }

    public function epreuvesGestion(): View
    {
        return view('gestion.epreuves');
    }
    public function colleges(): View
    {
        return view('gestion.colleges');
    }
    public function abonnement(): View
    {
        $demandes = Utilisateur::afficher_demandes_abo();
        return view('gestion.abonnement', ['demandes' => $demandes]);
    }
    public function supprimer_auto_abo()
    {
        $demandes = Utilisateur::afficher_demandes_abo();
        return view('gestion.supprimer_auto_abo', ['demandes' => $demandes]);
    }
    public function role(): View
    {
        return view('gestion.role');
    }
    public function edition(): View
    {
        return view('gestion.edition');
    }
    public function exportation(): View
    {
        return view('gestion.exportation');
    }
    public function modification(): View
    {
        return view('gestion.modification');
    }

    public function genre(): View
    {
        return view('admin.genre');
    }
    public function pays(): View
    {
        return view('admin.pays');
    }
    public function utilisateurs(): View
    {
        return view('admin.utilisateurs');
    }
}
