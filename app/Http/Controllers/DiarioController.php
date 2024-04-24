<?php

namespace App\Http\Controllers;

use App\Models\Diario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Post;

class DiarioController extends Controller
{
    public function index()
    {
        $diarioPosts = Diario::with('posts')->get(); // Recupera todos os posts relacionados para cada entrada do diário

        return view('insta.diario', compact('diarioPosts'));
    }

    public function create()
    {
        return view('insta.diario');
    }

    
    public function store(Request $request)
{
    $request->validate([
        'content' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'caption' => 'nullable|string|max:255', // Adicione a regra de validação para a legenda
        // Adicione a validação para os campos de conteúdo da postagem
        'post_content_0' => 'nullable|string|max:255',
        'post_content_1' => 'nullable|string|max:255',
        'post_content_2' => 'nullable|string|max:255',
    ]);

    // O redirecionamento automático acontecerá se houver erros de validação
    // Não é necessário verificar manualmente $validator->fails()

    $diarioPost = new Diario();
    $diarioPost->content = $request->input('content');
    // Salve a imagem se necessário
    $diarioPost->save();

    $postIds = [];

    // Crie 1, 2 ou 3 posts para esta entrada do diário
    for ($i = 0; $i < 3; $i++) {
        if ($request->has('post_content_' . $i)) {
            $post = new Post();
            $post->content = $request->input('post_content_' . $i);
            $post->diario_id = $diarioPost->id;
            // Associe o ID do usuário autenticado à postagem
            $post->user_id = auth()->user()->id;
            $post->save();

            // Adicione o ID da postagem à lista de IDs
            $postIds[] = $post->id;
        }
    }

    // Converta a lista de IDs em uma string separada por vírgulas
    $postIdsString = implode(',', $postIds);

    // Associe os IDs das postagens à entrada do diário
    $diarioPost->post_ids = $postIdsString;
    $diarioPost->save();

    return redirect()->back()->with('success', 'Entrada do diário criada com sucesso!');
}

}
