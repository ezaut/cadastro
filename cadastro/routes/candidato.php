<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidatoController;


Route::prefix('candidato')->name('candidato.')->group(function(){

    Route::middleware(['guest:candidato', 'PreventBackHistory'])->group(function(){
        Route::view('/login', 'back.pages.candidato.auth.login')->name('login');
        Route::post('/login_handler', [CandidatoController::class, 'loginHandler'])->name('login_handler');
        Route::get('/register', [CandidatoController::class, 'create'])->name('register');
        Route::post('/register', [CandidatoController::class, 'store']);
        Route::view('/forgot-password', 'back.pages.candidato.auth.forgot-password')->name('forgot-password');
        Route::post('/send-password-reset-link', [CandidatoController::class, 'sendPasswordResetLink'])->name('send-password-reset-link');
        Route::get('/password/reset/{token}', [CandidatoController::class, 'resetPassword'])->name('reset-password');
        Route::post('/reset-password-handler', [CandidatoController::class, 'resetPasswordHandler'])->name('reset-password-handler');


    });

    Route::middleware(['auth:candidato','PreventBackHistory'])->group(function(){
        Route::view('/home', 'back.pages.candidato.home')->name('home');
        Route::post('/logout_handler', [CandidatoController::class, 'logoutHandler'])->name('logout_handler');
    });

});
