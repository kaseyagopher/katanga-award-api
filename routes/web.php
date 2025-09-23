<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login',[AuthController::class, 'loginUser']);

Route::get('/loginAdmin',[AuthController::class, 'admin'])->name('admin.login');
Route::post('/loginAdmin',[AuthController::class, 'loginAdmin']);

Route::get('/logout',[AuthController::class, 'logout'])->name('admin.logout');

Route::get('/admin/dashboard',[AdminController::class, 'index'])->name('admin.index');

