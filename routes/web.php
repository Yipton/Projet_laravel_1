<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AutoInscriptionsController;
use App\Http\Controllers\PageController;

// --- Pages principales ---
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/mentions', [PageController::class, 'mentions'])->name('mentions');

// --- Préinscription ---
Route::get('/preinscription', [PageController::class, 'create'])->name('preinscription');
Route::post('/preinscription', [AutoInscriptionsController::class, 'store'])->name('preinscription.store');

// --- Vérification email ---
Route::get('/email/verify', function () {
    return view('auth.lien_envoye');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('inscription');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// Collèges
Route::get('/colleges/eleves', [PageController::class, 'eleves'])->name('colleges.eleves');
Route::get('/colleges/equipe', [PageController::class, 'equipe'])->name('colleges.equipe');

// Épreuves
Route::get('/epreuves', [PageController::class, 'epreuves'])->name('epreuves.index');

// Classement
Route::get('/classement', [PageController::class, 'classement'])->name('classement.index');

// Édition
Route::get('/edition/2024', [PageController::class, 'show2024'])->name('edition.2024');
Route::get('/edition/2025', [PageController::class, 'show2025'])->name('edition.2025');

// Saisie Note
Route::get('/saisie-note', [PageController::class, 'saisie_note'])->name('saisieNote.index');

// Page Gestion
Route::prefix('gestion')->group(function () {
    Route::get('/epreuves', [PageController::class, 'epreuves'])->name('gestion.epreuves');
    Route::get('/colleges', [PageController::class, 'colleges'])->name('gestion.colleges');
    Route::get('/abonnement', [PageController::class, 'abonnement'])->name('gestion.abonnement');
    Route::get('/role', [PageController::class, 'role'])->name('gestion.role');
    Route::get('/edition', [PageController::class, 'edition'])->name('gestion.edition');
    Route::get('/exportation', [PageController::class, 'exportation'])->name('gestion.exportation');
    Route::get('/modification', [PageController::class, 'modification'])->name('gestion.modification');
});

// Page Admin
Route::prefix('admin')->group(function () {
    Route::get('/genre', [PageController::class, 'genre'])->name('admin.genre');
    Route::get('/pays', [PageController::class, 'pays'])->name('admin.pays');
    Route::get('/utilisateurs', [PageController::class, 'utilisateurs'])->name('admin.utilisateurs');
});
// --- Inscription ---
Route::get('/inscription', [PageController::class, 'inscription'])
    ->middleware(['auth', 'verified'])
    ->name('inscription');

Route::post('/inscription', [AutoInscriptionsController::class, 'inscription'])
    ->name('inscription.store');

// --- Pages protégées ---
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// --- Collèges ---
Route::get('/colleges/eleves', [PageController::class, 'eleves'])->name('colleges.eleves');
Route::get('/colleges/equipe', [PageController::class, 'equipe'])->name('colleges.equipe');

require __DIR__ . '/auth.php';
