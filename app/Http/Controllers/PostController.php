<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
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
}
