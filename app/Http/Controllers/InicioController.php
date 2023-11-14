<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class InicioController extends Controller
{
    public function index($loadedPosts = 5)
{
    $posts = Post::latest()->take($loadedPosts)->get();

    return view('insta.feed', [
        'posts' => $posts,
        'noPosts' => $posts->isEmpty(),
        'loadedPosts' => $loadedPosts,
    ]);
}

public function loadMorePosts($loadedPosts)
    {
        // Atualize a variável $loadedPosts conforme necessário
        // e redirecione de volta para a página de feed
        $updatedLoadedPosts = $loadedPosts + 5;

        return redirect()->route('feed', ['loadedPosts' => $updatedLoadedPosts]);
    }

}
