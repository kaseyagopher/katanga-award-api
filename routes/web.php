<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\EditionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use App\Models\Vote;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login',[AuthController::class, 'loginUser']);

Route::get('/loginAdmin',[AuthController::class, 'admin'])->name('admin.login');
Route::post('/loginAdmin',[AuthController::class, 'loginAdmin']);
Route::get('/logout', [AuthController::class,'user_logout'])->name('user.logout');

Route::get('/logout',[AuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard',[AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('editions', EditionController::class);
    Route::resource('categories', CategorieController::class);
    Route::resource('candidats', CandidatController::class);
});

Route::prefix('user')->group(function(){
    Route::get('/',[UserController::class, 'index'])->name('user.index');
    Route::get('/vote',[UserController::class, 'vote'])->name('user.vote');
    Route::post('/vote',[VoteController::class, 'store'])->name('vote.store');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});