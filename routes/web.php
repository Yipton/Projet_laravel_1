<?php


use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AutoInscriptionsController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::view('/', 'accueil');

Route::view('/mentions', 'mentions');

Route::view('/preinscription', 'preinscription')->name('preinscription.form');
Route::post('/preinscription', [AutoInscriptionsController::class, 'store'])
    ->name('preinscription.store');

//The Email Verification Notice
Route::get('/email/verify', function () {
    return view('auth.lien_envoye');
})->middleware('auth')->name('verification.notice');

//The Email Verification Handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('inscription');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Afficher la page d'inscription
Route::get('/inscription', function (Request $request) {

    return view('auth.inscription');
})->middleware(['auth', 'verified'])->name('inscription');

//Resending the Verification Email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('/inscription', [AutoInscriptionsController::class, 'inscription'])
    ->name('inscription.store');

require __DIR__ . '/auth.php';
