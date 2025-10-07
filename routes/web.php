<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EditionController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\ResultatController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\VoteSummaryController;
use Illuminate\Support\Facades\Route;

Route::prefix('katanga-award')->group(function () {

    // =============================
    // 🔓 ROUTES PUBLIQUES
    // =============================
    Route::get('/', fn() => to_route('login'));

    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'loginUser']);

    Route::get('/loginAdmin', [AuthController::class, 'admin'])->name('admin.login');
    Route::post('/loginAdmin', [AuthController::class, 'loginAdmin']);

    // =============================
    // 🔓 ROUTES UTILISATEUR PUBLIQUES
    // =============================
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/apropos', [UserController::class, 'user_apropos'])->name('user.apropos');
        Route::get('/contact', [UserController::class, 'user_contact'])->name('user.contact');
        Route::post('/mail', [UserController::class, 'user_mail'])->name('user.mail');
        Route::get('/candidat/{id}', [UserController::class, 'showCandidat'])->name('user.candidat.show');
    });

    // =============================
    // 🔒 ROUTES UTILISATEUR PROTÉGÉES
    // =============================
    Route::prefix('user')->group(function () {
        Route::get('/vote', [UserController::class, 'vote'])->name('user.vote');
        Route::post('/vote', [VoteController::class, 'store'])->name('vote.store');
        Route::get('/vote/summary', [UserController::class, 'showVoteSummary'])->name('vote.summary');
        Route::get('/logout', [UserController::class, 'user_logout'])->name('user.logout');
    });

    // =============================
    // 🔒 ROUTES ADMIN PROTÉGÉES
    // =============================
    Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::resource('editions', EditionController::class);
        Route::resource('categories', CategorieController::class);
        Route::resource('candidats', CandidatController::class);
        Route::get('/resultats', [ResultatController::class, 'index'])->name('resultats.index');
        Route::get('/resultats/data', [ResultatController::class, 'data'])->name('resultats.data');
        Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    });

    // =============================
    // ⚠️ PAGE 404
    // =============================
    Route::fallback(function () {
        return response()->view('errors.404', [], 404);
    });

});
