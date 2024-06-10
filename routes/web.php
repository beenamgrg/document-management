<?php

use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SessionController::class, 'index'])->name('home');
Route::post('/login',  [SessionController::class, 'login'])->name('login.submit');
Route::post('/logout',  [SessionController::class, 'logout'])->name('logout.submit');

