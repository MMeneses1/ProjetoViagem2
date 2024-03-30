<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

class InicioController extends Controller
{
    public function index($loadedPosts = 5)
{
  $posts = Post::latest()->paginate($loadedPosts);
  $postsPage = $posts->currentPage();
  $postsCount = Post::count();

  return view('insta.feed', [
    'posts' => $posts,
    'noPosts' => $posts->isEmpty(),
    'loadedPosts' => $loadedPosts,
    'postsCount' => $postsCount,
    'postsPage' => $postsPage,
  ]);
}



}
