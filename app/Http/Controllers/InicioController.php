<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Models\User;

class InicioController extends Controller
{
  public function index($loadedPosts = 0)
  {
      // Obtenha as recomendações de usuários
      $recommendations = $this->getRecommendations();
  
      // Obtenha os posts
      $posts = Post::latest()->paginate($loadedPosts);
      $postsPage = $posts->currentPage();
      $postsCount = Post::count();
  
      return view('insta.feed', [
          'posts' => $posts,
          'noPosts' => $posts->isEmpty(),
          'loadedPosts' => $loadedPosts,
          'postsCount' => $postsCount,
          'postsPage' => $postsPage,
          'recommendations' => $recommendations, // Passe as recomendações para a view
      ]);
  }

  public function getRecommendations()
{
    $user = auth()->user();

    // Verificar se o usuário segue alguém
    if ($user->following()->exists()) {
        // Obter seguidores dos seguidores do usuário
        $friendsOfFriends = $user->followers()->with('followers')->get()->flatMap->followers->pluck('usuarios.id')->unique();

        // Obter usuários seguidos pelo usuário
        $followingIds = $user->following()->pluck('usuarios.id');

        // Obter usuários que são amigos de amigos, excluindo aqueles que o usuário já segue e o próprio usuário
        $friendsOfFriendsNotFollowing = User::whereIn('usuarios.id', $friendsOfFriends)
            ->whereNotIn('usuarios.id', $followingIds)
            ->where('usuarios.id', '!=', $user->id)
            ->limit(4)
            ->get();

        $numRecommendations = $friendsOfFriendsNotFollowing->count();

        // Obter usuários aleatórios que o usuário não segue, se necessário
        if ($numRecommendations < 4) {
            $randomUsersNotFollowing = User::whereNotIn('usuarios.id', $followingIds->merge([$user->id]))
                ->whereNotIn('usuarios.id', $friendsOfFriends)
                ->inRandomOrder()
                ->limit(4 - $numRecommendations)
                ->get();

            // Combinar os usuários encontrados
            $recommendations = $friendsOfFriendsNotFollowing->concat($randomUsersNotFollowing);
        } else {
            $recommendations = $friendsOfFriendsNotFollowing;
        }
    } else {
        // Se o usuário não seguir ninguém, obtenha cinco usuários aleatórios excluindo o próprio usuário
        $recommendations = User::where('usuarios.id', '!=', $user->id)->inRandomOrder()->limit(5)->get();
    }

    return $recommendations;
}

}
