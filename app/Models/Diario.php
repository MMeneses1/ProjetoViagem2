<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diario extends Model
{
    protected $fillable = ['content', 'post_ids'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'diario_id');
    }
}