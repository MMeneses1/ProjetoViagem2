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
            'address' => 'nullable|string|max:255', // Validação para o campo de endereço
            // Validações para os campos de conteúdo da postagem e imagens das postagens
            'post_content_0' => 'nullable|string|max:255',
            'post_content_1' => 'nullable|string|max:255',
            'post_content_2' => 'nullable|string|max:255',
            'post_image_0' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'post_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'post_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Crie uma nova entrada do diário
        $diarioPost = new Diario();
        $diarioPost->content = $request->input('content');
    
        // Salve o endereço, se presente
        $diarioPost->address = $request->input('address');
    
        $diarioPost->save();

    $postIds = [];

    // Crie 1, 2 ou 3 posts para esta entrada do diário
    for ($i = 0; $i < 3; $i++) {
        if ($request->has('post_content_' . $i) || $request->hasFile('post_image_' . $i)) {
            $post = new Post();
            $post->content = $request->input('post_content_' . $i);

            // Salve a imagem da postagem, se presente
            if ($request->hasFile('post_image_' . $i)) {
                $imagePath = $request->file('post_image_' . $i)->store('public/images');
                $post->image = str_replace('public/', 'storage/', $imagePath);
            }

            // Salvar a legenda, se presente
            if ($request->has('caption_' . $i)) {
                $post->caption = $request->input('caption_' . $i);
            }

            $post->diario_id = $diarioPost->id;
            $post->user_id = auth()->user()->id;
            $post->save();

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
