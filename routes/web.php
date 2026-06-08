<?php

use App\Models\Vote;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EditionController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\ResultatController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\VoteAdminController;
use App\Http\Controllers\VoteSummaryController;

Route::prefix('katanga-award')->group(function () {

    Route::get('/', function () {
        return to_route('user.index');
    });

    Route::get('/loginAdmin',[AuthController::class, 'admin'])->name('admin.login');
    Route::post('/loginAdmin',[AuthController::class, 'loginAdmin']);

    Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard',[AdminController::class, 'index'])->name('admin.dashboard');
        Route::resource('editions', EditionController::class);
        Route::post('editions/{edition}/close', [EditionController::class, 'close'])->name('editions.close');
        Route::post('editions/{edition}/reactivate', [EditionController::class, 'reactivate'])->name('editions.reactivate');
        Route::post('editions/{edition}/consult', [EditionController::class, 'consult'])->name('editions.consult');
        Route::post('editions/consultation/leave', [EditionController::class, 'leaveConsultation'])->name('editions.consultation.leave');
        Route::resource('categories', CategorieController::class);
        Route::resource('candidats', CandidatController::class);
        Route::get('/resultats', [ResultatController::class, 'index'])->name('resultats.index');
        Route::get('/resultats/data', [ResultatController::class, 'data'])->name('resultats.data');
        Route::get('/votes', [VoteAdminController::class, 'index'])->name('admin.gestion-votes');
    Route::delete('/votes/{id}', [VoteAdminController::class, 'destroy'])->name('admin-vote-destroy');
    });

    Route::prefix('user')->group(function(){
        Route::get('/',[UserController::class, 'index'])->name('user.index');
        Route::get('/apropos',[UserController::class, 'user_apropos'])->name('user.apropos');
        Route::get('/contact',[UserController::class, 'user_contact'])->name('user.contact');
        Route::post('/mail',[UserController::class, 'user_mail'])->name('user.mail'); // pour mail
        Route::get('/vote',[UserController::class, 'vote'])->name('user.vote');
        Route::get('/candidat/{candidat:uuid}', [UserController::class, 'showCandidat'])->name('user.candidat.show');

        Route::get('/publicite',[UserController::class,'publicite'])->name('user.publicite');
        Route::post('/vote', [VoteController::class, 'store'])->name('vote.store');
        Route::get('/vote/paiement', [VoteController::class, 'payment'])->name('vote.payment');
        Route::post('/vote/paiement', [VoteController::class, 'processPayment'])->name('vote.payment.process');
        Route::get('/vote/summary', [VoteSummaryController::class, 'show'])->name('vote.summary');
    });

    Route::fallback(function () {
        return response()->view('errors.404', [], 404);
    });

});

Route::get('/carou',function(){
    return view('welcome');
});
