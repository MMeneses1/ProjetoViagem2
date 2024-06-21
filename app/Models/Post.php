<?php

// app/Models/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'diario_id']; // Adicione 'caption' ao $fillable

    protected $table = 'posts';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function diario()
    {
        return $this->belongsTo(Diario::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function paginas()
    {
        return $this->hasMany(Pagina::class);
    }

}
