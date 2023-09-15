<?php

use App\Http\Controllers\MVPController;
use App\Http\Controllers\AuthController;

Route::get('/iniciar', [MVPController::class, 'showLoginForm'])->name('login');
Route::post('/iniciar', [AuthController::class, 'authenticate']);

Route::get('/consegui', function () {
    return view('consegui'); // Você pode personalizar isso conforme necessário
    })->name('consegui');


Route::get('/register', [MVPController::class, 'showRegisterForm'])->name('insta.register');
Route::post('/register', [MVPController::class, 'register'])->name('register');



