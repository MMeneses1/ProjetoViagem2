<?php

use App\Http\Controllers\MVPController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;


Route::get('/iniciar', [MVPController::class, 'showLoginForm'])->name('login');
Route::post('/iniciar', [AuthController::class, 'authenticate']);

Route::get('/consegui', function () {
    return view('consegui'); 
})->name('consegui');

Route::get('/register', [MVPController::class, 'showRegisterForm'])->name('insta.register');
Route::post('/register', [MVPController::class, 'register'])->name('register');

Route::middleware('auth')->group(function () {
    // Rotas protegidas por autenticação

    Route::get('/perfil', [MVPController::class, 'showProfile'])->name('perfil');
    Route::post('/logout', [MVPController::class, 'logout'])->name('logout');

    Route::get('/perfil/editar', [MVPController::class, 'showProfileEditForm'])->name('insta.perfiledit');
    Route::post('/perfil/editar', [MVPController::class, 'updateProfile'])->name('perfil.update');

    Route::post('/post', [PostController::class, 'store'])->name('post.store');


});
