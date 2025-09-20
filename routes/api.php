<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\EditionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* 
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/


Route::apiResource('admins', AdminController::class);
Route::apiResource('candidats', CandidatController::class);
Route::apiResource('editions', EditionController::class);
Route::apiResource('users', UserController::class);

Route::post('loginAdmin', [AuthController::class, 'loginAdmin']);

Route::post('loginUser',[AuthController::class, 'loginUser']);

Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');