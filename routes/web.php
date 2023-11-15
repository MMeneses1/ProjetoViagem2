<?php

use App\Http\Controllers\MVPController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\InicioController;

Route::get('/', [MVPController::class, 'showLoginForm'])->name('login');
Route::get('/login', [MVPController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

Route::get('/signup', [MVPController::class, 'showRegisterForm'])->name('insta.register');
Route::post('/signup', [MVPController::class, 'register'])->name('register');

Route::middleware('auth')->group(function () {
    // Rotas protegidas por autenticação
    Route::get('/perfil', [MVPController::class, 'showProfile'])->name('perfil');
    Route::post('/perfilpessoal', [MVPController::class, 'updateDados'])->name('perfilpessoal.update');
    Route::post('/logout', [MVPController::class, 'logout'])->name('logout');
    Route::get('/perfil/editar', [MVPController::class, 'showProfileEditForm'])->name('insta.perfiledit');
    Route::post('/perfil/editar', [MVPController::class, 'updateProfile'])->name('perfil.update');
    Route::get('/perfil/{username?}', [MVPController::class, 'showOtherUserProfile'])->name('perfil.outro');
    Route::get('/perfil/{loadedPosts?}', [MVPController::class, 'showProfile'])->name('perfil');

    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.delete');

    Route::post('/comment/{post}', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.delete');
    Route::get('/comment/{comment}/edit', [CommentController::class, 'edit'])->name('comment.edit');
    Route::put('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');

    Route::get('/feed', [InicioController::class, 'index'])->name('feed');
    Route::get('/feed/{loadedPosts?}', [InicioController::class, 'index'])->name('feed');
    Route::get('/load-more-posts/{loadedPosts}', [InicioController::class, 'loadMorePosts'])->name('load.more.posts');
    
    Route::get('/pesquisa', [MVPController::class, 'pesquisar'])->name('pesquisa');

    Route::get('/pesquisa', [MVPController::class, 'pesquisar'])->name('pesquisa');
    Route::get('/pesquisa-ao-digitar', [MVPController::class, 'pesquisarAoDigitar'])->name('pesquisa.ao.digitar');

    Route::post('/perfil/seguir/{username}', [MVPController::class, 'followUser'])->name('perfil.seguir');
    Route::post('/perfil/deixar-de-seguir/{username}', [MVPController::class, 'unfollowUser'])->name('perfil.deixar-de-seguir');
    
    Route::get('/get-followers', [MVPController::class, 'getFollowers'])->name('get.followers');
    Route::get('/get-following', [MVPController::class, 'getFollowing'])->name('get.following');

});
