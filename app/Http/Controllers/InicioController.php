<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class InicioController extends Controller
{
    public function index()
    {
        // Adicione qualquer lógica que você precise para obter os posts ou outros dados aqui
        $posts = Post::all(); // Substitua isso pela forma como você obtém seus posts

        return view('insta.login', [
            'posts' => $posts,
            'noPosts' => $posts->isEmpty(),
        ]);
    }
}
