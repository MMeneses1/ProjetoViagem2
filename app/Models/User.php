<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'nome',
        'username',
        'password',
        'sexo',
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

    protected $table = 'usuarios';

    /**
     * Relacionamento muitos para muitos para os usuários que este usuário está seguindo.
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    /**
     * Relacionamento muitos para muitos para os usuários que estão seguindo este usuário.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    /**
     * Verifica se este usuário está seguindo outro usuário.
     */
    public function isFollowing($user)
    {
        return $this->following->contains($user);
    }

    /**
     * Verifica se este usuário está sendo seguido por outro usuário.
     */
    public function isFollowedBy($user)
    {
        return $this->followers->contains($user);
    }

    /**
     * Relacionamento um para muitos para os posts deste usuário.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Verifica se o usuário pode excluir um comentário.
     */
    public function canDeleteComment(Comment $comment)
    {
        return $this->id === $comment->user_id || $this->id === $comment->post->user_id;
    }

    /**
     * Verifica se o usuário pode editar um comentário.
     */
    public function canEditComment(Comment $comment)
    {
        return $this->id === $comment->user_id;
    }
}
