<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Livewire\Component;

class PostController extends Component
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255', // Adicione a regra de validação para a legenda
        ]);

        $post = new Post();
        $post->content = $request->input('content');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $post->image = str_replace('public/', 'storage/', $imagePath);
        }

        // Salvar a legenda
        $post->caption = $request->input('caption');

        $post->user_id = auth()->user()->id;
        $post->save();

        return redirect()->back()->with('success', 'Postagem criada com sucesso.');
    }

    public function destroy(Post $post)
    {
        // Verifique se o usuário autenticado é o proprietário do post
        if (auth()->user()->id === $post->user_id) {
            // Exclua o post e seus comentários relacionados, se necessário
            $post->comments()->delete(); // Isso exclui todos os comentários relacionados ao post
            $post->delete();

            return redirect()->back()->with('success', 'Post excluído com sucesso.');
        }

        return redirect()->back()->with('error', 'Você não tem permissão para excluir este post.');
    }

    public function redirecionarParaOutraPagina($rota)
    {
        // Redireciona para outra página
        return redirect()->to($rota);
    }

    public function render()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();

        return view('login', compact('posts'));
    }
}
