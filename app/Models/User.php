<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
}

