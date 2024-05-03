<?php

use App\Http\Controllers\MVPController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\DiarioController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', [MVPController::class, 'showLoginForm'])->name('login');
Route::get('/login', [MVPController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

Route::get('/signup', [MVPController::class, 'showRegisterForm'])->name('insta.register');
Route::post('/signup', [MVPController::class, 'register'])->name('register');

Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware('auth')->group(function () {
    // Rotas protegidas por autenticação
    Route::get('/perfil', [MVPController::class, 'showProfile'])->name('perfil');
    Route::post('/logout', [MVPController::class, 'logout'])->name('logout');
    Route::get('/perfil/editar', [MVPController::class, 'showProfileEditForm'])->name('insta.perfiledit');
    Route::post('/perfil/editar', [MVPController::class, 'updateProfile'])->name('perfil.update');
    Route::get('/perfil/{username?}', [MVPController::class, 'showOtherUserProfile'])->name('perfil.outro');
    Route::get('/perfil/{loadedPosts?}', [MVPController::class, 'showProfile'])->name('perfil');
    Route::get('/testepaginapost', [MVPController::class, 'showTestePaginaPost'])->name('testepaginapost');


    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.delete');

    Route::post('/comment/{post}', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.delete');
    Route::get('/comment/{comment}/edit', [CommentController::class, 'edit'])->name('comment.edit');
    Route::put('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');

    Route::get('/feed', [InicioController::class, 'render'])->name('feed');
    
    
    Route::get('/pesquisa', [MVPController::class, 'pesquisar'])->name('pesquisa');

    Route::get('/pesquisa', [MVPController::class, 'pesquisar'])->name('pesquisa');
    Route::get('/pesquisa-ao-digitar', [MVPController::class, 'pesquisarAoDigitar'])->name('pesquisa.ao.digitar');

    Route::post('/perfil/seguir/{username}', [MVPController::class, 'followUser'])->name('perfil.seguir');
    Route::post('/perfil/deixar-de-seguir/{username}', [MVPController::class, 'unfollowUser'])->name('perfil.deixar-de-seguir');
    
    Route::get('/get-followers', [MVPController::class, 'getFollowers'])->name('get.followers');
    Route::get('/get-following', [MVPController::class, 'getFollowing'])->name('get.following');

    Route::get('/diario', [DiarioController::class, 'render'])->name('diario.render');
    Route::post('/diario', [DiarioController::class, 'store'])->name('diario.store');

});
