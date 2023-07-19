<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServidorController;


Route::prefix('servidor')->name('servidor.')->group(function(){

    Route::middleware(['guest:servidor', 'PreventBackHistory'])->group(function(){
        Route::view('/login', 'back.pages.servidor.auth.login')->name('login');
        Route::post('/login_handler', [ServidorController::class, 'loginHandler'])->name('login_handler');
        Route::view('/forgot-password', 'back.pages.servidor.auth.forgot-password')->name('forgot-password');
        Route::post('/send-password-reset-link', [ServidorController::class, 'sendPasswordResetLink'])->name('send-password-reset-link');
        Route::get('/password/reset/{token}', [ServidorController::class, 'resetPassword'])->name('reset-password');
        Route::post('/reset-password-handler', [ServidorController::class, 'resetPasswordHandler'])->name('reset-password-handler');


    });

    Route::middleware(['auth:servidor','PreventBackHistory'])->group(function(){
        Route::view('/home', 'back.pages.servidor.home')->name('home');
        Route::post('/logout_handler', [ServidorController::class, 'logoutHandler'])->name('logout_handler');
    });

});
