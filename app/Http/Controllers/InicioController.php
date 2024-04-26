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
        // Obter os IDs dos usuários seguidos pelo usuário
        $followingIds = $user->following()->pluck('usuarios.id');

        // Obter os IDs dos seguidores dos usuários seguidos pelo usuário
        $friendsOfFollowingIds = $user->following()->with('followers')->get()->flatMap->followers->pluck('followers.id')->unique();

        // Obter os IDs dos seguidores do usuário
        $followersIds = $user->followers()->pluck('followers.id');

        // Obter os IDs dos usuários que seguem o usuário mas não são seguidos de volta
        $followersNotFollowingBackIds = $followersIds->diff($followingIds);

        // Obter amigos aleatórios dos amigos que o usuário segue
        $randomFriendsOfFriendsIds = User::whereIn('usuarios.id', $friendsOfFollowingIds)
            ->whereNotIn('usuarios.id', $followingIds)
            ->where('usuarios.id', '!=', $user->id)
            ->inRandomOrder()
            ->limit(3)
            ->pluck('usuarios.id');

        // Obter um seguidor do usuário que não é seguido de volta
        $randomFollowerNotFollowingBackId = $followersNotFollowingBackIds->random();

        // Obter um usuário aleatório que o usuário não segue
        $randomUserNotFollowingId = User::whereNotIn('usuarios.id', $followingIds->merge([$user->id]))
            ->inRandomOrder()
            ->where('usuarios.id', '!=', $user->id) // Garantir que o próprio usuário não seja incluído
            ->value('usuarios.id');

        // Combinar todos os IDs em uma lista
        $recommendationsIds = $randomFriendsOfFriendsIds->merge([$randomFollowerNotFollowingBackId, $randomUserNotFollowingId])->unique();

        // Obter os usuários correspondentes aos IDs
        $recommendations = User::whereIn('usuarios.id', $recommendationsIds)->get();

        // Se a contagem de recomendações for inferior a 5, preencha com usuários aleatórios
        while ($recommendations->count() < 5) {
            $randomUsers = User::whereNotIn('usuarios.id', $followingIds->merge([$user->id])) // Exclua os usuários que o usuário já segue
                ->where('usuarios.id', '!=', $user->id) // Garantir que o próprio usuário não seja incluído
                ->inRandomOrder()
                ->limit(5 - $recommendations->count())
                ->get();
            $recommendations = $recommendations->merge($randomUsers);
        }

        return $recommendations;
    } else {
        // Se o usuário não segue ninguém, recomende 5 usuários aleatórios, excluindo o próprio usuário
        $randomUsers = User::where('usuarios.id', '!=', $user->id)->inRandomOrder()->limit(5)->get();
        return $randomUsers;
    }
}

  

}
