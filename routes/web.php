<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AutoInscriptionsController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\CheckRole;

// --- Pages principales ---
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/mentions', [PageController::class, 'mentions'])->name('mentions');

// --- Préinscription ---
Route::get('/preinscription', [PageController::class, 'create'])->name('preinscription')->middleware(CheckRole::class . ':1,90');
Route::post('/preinscription', [AutoInscriptionsController::class, 'store'])->name('preinscription.store')->middleware(CheckRole::class . ':1,90');

// --- Lien de vérification email ---
Route::get('/email/verify', [PageController::class, 'lien_verif_email_envoye'])
    ->middleware('auth')->name('verification.notice');

// --- Inscription ---
// 1) En cliquant sur le lien du mail -> vérif du mail
Route::get(
    '/email/verify/{id}/{hash}',
    [PageController::class, 'email_verification']
)->middleware(['auth', 'signed'])->name('verification.verify');

// 2) Afficher le formulaire d'inscription après la vérif
Route::get('/inscription', [PageController::class, 'inscription'])
    ->middleware(['auth', 'verified'])
    ->name('inscription');

// 3) En validant le formulaire d'inscription
Route::post('/inscription', [AutoInscriptionsController::class, 'inscription'])
    ->name('inscription.store');

// --- Renvoyer la vérification d'email ---
Route::post('/email/verification-notification', [AutoInscriptionsController::class, 'renvoyer_lien_verif_email'])
    ->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Page "mot de passe oublié" (entrée)
Route::get('/forgot-password', function () {
    return view('livewire.pages.auth.reset-password');
})->middleware('guest')->name('password.request');

// Collèges
Route::get('/colleges/eleves', [PageController::class, 'eleves'])->name('colleges.eleves')->middleware(CheckRole::class . ':60,90');
Route::get('/colleges/equipe', [PageController::class, 'equipe'])->name('colleges.equipe')->middleware(CheckRole::class . ':60,90');

// Épreuves
Route::get('/epreuves', [PageController::class, 'epreuves'])->name('epreuves.index')->middleware(CheckRole::class . ':60,90');

// Classement
Route::get('/classement', [PageController::class, 'classement'])->name('classement.index');

// Saisie Note
Route::get('/saisie-note', [PageController::class, 'saisie_note'])->name('saisieNote.index')->middleware(CheckRole::class . ':50,90');

// Page Gestion
Route::prefix('gestion')->middleware(CheckRole::class . ':60,90')->group(function () {
    Route::get('/epreuves', [PageController::class, 'epreuves'])->name('gestion.epreuves');
    Route::get('/colleges', [PageController::class, 'colleges'])->name('gestion.colleges');
    Route::get('/abonnement', [PageController::class, 'abonnement'])->name('gestion.abonnement');
    Route::post('/abonnement', [AutoInscriptionsController::class, 'confirmer_auto_abo'])->name('gestion.confirmer_auto_abo');
    Route::get('/supprimer_auto_abo', [PageController::class, 'supprimer_auto_abo'])->name('gestion.supprimer_auto_abo');
    Route::post('/supprimer_auto_abo', [AutoInscriptionsController::class, 'supprimer_auto_abo'])->name('gestion.supprimer_abo');
    Route::get('/role', [PageController::class, 'role'])->name('gestion.role');
    Route::get('/edition', [PageController::class, 'edition'])->name('gestion.edition');
    Route::get('/exportation', [PageController::class, 'exportation'])->name('gestion.exportation');
    Route::get('/modification', [PageController::class, 'modification'])->name('gestion.modification');
});

// Page Admin
Route::prefix('admin')->middleware(CheckRole::class . ':90')->group(function () {
    Route::get('/genre', [PageController::class, 'genre'])->name('admin.genre');
    Route::get('/pays', [PageController::class, 'pays'])->name('admin.pays');
    Route::get('/utilisateurs', [PageController::class, 'utilisateurs'])->name('admin.utilisateurs');
});

// --- Collèges ---
Route::get('/colleges/eleves', [PageController::class, 'eleves'])->name('colleges.eleves')->middleware(CheckRole::class . ':30,90');
Route::get('/colleges/equipe', [PageController::class, 'equipe'])->name('colleges.equipe')->middleware(CheckRole::class . ':30,90');

require __DIR__ . '/auth.php';
