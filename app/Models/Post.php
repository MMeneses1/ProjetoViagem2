<?php

// app/Models/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content', 'image', 'caption']; // Adicione 'caption' ao $fillable

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
