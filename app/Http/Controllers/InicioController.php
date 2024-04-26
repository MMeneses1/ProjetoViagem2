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
    $recommendations = $this->getRecommendationsForUser();

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

public function getRecommendationsForUser()
{
    $user = auth()->user();

    // Obtenha os IDs dos usuários que o usuário segue
    $followingIds = $user->following()->pluck('usuarios.id');

    // Se o usuário seguir alguém
    if ($followingIds->isNotEmpty()) {
        // Obtenha os IDs dos amigos dos amigos que o usuário segue
        $friendsOfFollowingIds = $user->following()->with('followers')->get()->flatMap->followers->pluck('usuarios.id')->unique();

        // Obtenha os IDs dos seguidores do usuário
        $followersIds = $user->followers()->pluck('usuarios.id');

        // Obtenha os IDs dos usuários que seguem o usuário mas não são seguidos de volta
        $followersNotFollowingBackIds = $followersIds->diff($followingIds);

        // Se o usuário seguir todos os que o seguem de volta, recomende os amigos desses usuários e usuários aleatórios
        if ($followersNotFollowingBackIds->isEmpty()) {
            // Obtenha amigos aleatórios dos amigos que o usuário segue
            $randomFriendsOfFriendsIds = User::whereIn('usuarios.id', $friendsOfFollowingIds)
                ->whereNotIn('usuarios.id', $followingIds)
                ->where('usuarios.id', '!=', $user->id)
                ->inRandomOrder()
                ->limit(3)
                ->pluck('usuarios.id');

            // Combine os IDs dos amigos dos amigos com os amigos dos amigos
            $recommendationsIds = $friendsOfFollowingIds->merge($randomFriendsOfFriendsIds)->unique();
        } else {
            // Obtenha um seguidor do usuário que não é seguido de volta
            $randomFollowerNotFollowingBackId = $followersNotFollowingBackIds->random();

            // Obtenha um usuário aleatório que o usuário não segue
            $randomUserNotFollowingId = User::whereNotIn('usuarios.id', $followingIds->merge([$user->id]))
                ->inRandomOrder()
                ->where('usuarios.id', '!=', $user->id) // Garantir que o próprio usuário não seja incluído
                ->value('usuarios.id');

            // Combine todos os IDs em uma lista
            $recommendationsIds = $randomFollowerNotFollowingBackId ? $friendsOfFollowingIds->merge([$randomFollowerNotFollowingBackId, $randomUserNotFollowingId])->unique() : $friendsOfFollowingIds;
        }

        // Obtenha os usuários correspondentes aos IDs
        $recommendations = User::whereIn('usuarios.id', $recommendationsIds)->get();

        // Se houver menos de 5 usuários recomendados, preencha com usuários aleatórios
        $countToFill = max(5 - $recommendations->count(), 0);
        if ($countToFill > 0) {
            $randomUsers = User::whereNotIn('usuarios.id', $followingIds->merge([$user->id])) // Exclua os usuários que o usuário já segue
                ->where('usuarios.id', '!=', $user->id) // Garantir que o próprio usuário não seja incluído
                ->inRandomOrder()
                ->limit($countToFill)
                ->get();
            $recommendations = $recommendations->merge($randomUsers);
        }

        return $recommendations;
    } else {
        // Se o usuário não seguir ninguém, recomende usuários aleatórios, excluindo o próprio usuário
        return User::where('usuarios.id', '!=', $user->id)->inRandomOrder()->limit(5)->get();
    }
}

  

}
