<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SessionController::class, 'index'])->name('index');
Route::post('/login',  [SessionController::class, 'login'])->name('login.submit');


Route::middleware('LoginCheck')->group(function ()
{
    Route::post('/logout',  [SessionController::class, 'logout'])->name('logout.submit');
    Route::get('/dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index');

    //Routes for JOB APPLICATION
});
