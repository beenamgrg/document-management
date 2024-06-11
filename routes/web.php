<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;




Route::get('/', [SessionController::class, 'index'])->name('index');
Route::get('/login', [SessionController::class, 'index'])->name('login');
Route::get('/sign-up', [SessionController::class, 'signUp'])->name('sign-up');

Route::post('/sign-up',  [SessionController::class, 'userRegister'])->name('sign-up.submit');
Route::post('/login',  [SessionController::class, 'login'])->name('login.submit');
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.auth');
Route::get('auth/google/call-back ', [GoogleAuthController::class, 'handleGoogleCallback']);




Route::group(['middleware' => ['LoginCheck']], function ()
{
    Route::post('/logout',  [SessionController::class, 'logout'])->name('logout.submit');
    Route::get('/dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index');

    //Documents Actions
    Route::post('/document/store',  [DocumentController::class, 'store'])->name('document.store');
    Route::get('/document/download',  [DocumentController::class, 'download'])->name('document.download');
    Route::post('/document/delete',  [DocumentController::class, 'delete'])->name('document.delete');
    Route::group(['middleware' => ['AdminCheck']], function ()
    {
        Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    });
});
