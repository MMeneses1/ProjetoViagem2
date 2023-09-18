<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Comment;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'email',
        'nome',
        'username',
        'password',
        'sexo', // Adicione os campos adicionais aqui
        'biografia',
        'telefone',
        'pais',
        'idioma',
        'foto_perfil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'usuarios'; // Defina o nome da tabela correta

    public function posts()
{
    return $this->hasMany(Post::class);
}


public function canDeleteComment(Comment $comment)
{
    // Verifique se o usuário é o autor do comentário OU o autor do post associado ao comentário
    return $this->id === $comment->user_id || $this->id === $comment->post->user_id;
}

public function canEditComment(Comment $comment)
{
    // Verifique se o usuário é o autor do comentário
    return $this->id === $comment->user_id;
}



}

