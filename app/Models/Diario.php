<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diario extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'user_id'];

    protected $table = 'diarios';

    public function posts()
    {
        return $this->hasMany(Post::class, 'diario_id');
    }
}