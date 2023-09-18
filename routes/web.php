<?php

use App\Http\Controllers\MVPController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\InicioController;


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
    Route::get('/perfilpessoal', [MVPController::class, 'showDados'])->name('perfilpessoal');
    Route::post('/perfilpessoal', [MVPController::class, 'updateDados'])->name('perfilpessoal.update');
    Route::post('/logout', [MVPController::class, 'logout'])->name('logout');
    Route::get('/perfil/editar', [MVPController::class, 'showProfileEditForm'])->name('insta.perfiledit');
    Route::post('/perfil/editar', [MVPController::class, 'updateProfile'])->name('perfil.update');

    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.delete');


    Route::post('/comment/{post}', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.delete');
    Route::get('/comment/{comment}/edit', [CommentController::class, 'edit'])->name('comment.edit');
    Route::put('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');

    Route::get('/inicio', [InicioController::class, 'index'])->name('inicio');

});
