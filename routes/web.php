<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;




Route::get('/', [SessionController::class, 'index'])->name('index');
Route::get('/login', [SessionController::class, 'index'])->name('login');
Route::get('/sign-up', [SessionController::class, 'signUp'])->name('sign-up');

Route::post('/sign-up',  [SessionController::class, 'userRegister'])->name('sign-up.submit');
Route::post('/login',  [SessionController::class, 'login'])->name('login.submit');
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.auth');
Route::get('auth/google/call-back ', [GoogleAuthController::class, 'handleGoogleCallback']);




Route::group(['middleware' => ['LoginCheck',]], function ()
{
    Route::post('/logout',  [SessionController::class, 'logout'])->name('logout.submit');
    Route::get('/dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index');
});
