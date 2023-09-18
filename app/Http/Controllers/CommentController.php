<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
{
    $request->validate([
        'comment_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $comment = new Comment();
    $comment->text = $request->input('comment', ''); // Define o texto como vazio se não houver entrada.

    if ($request->hasFile('comment_image')) {
        $imagePath = $request->file('comment_image')->store('public/comment_images');
        $comment->image = str_replace('public/', 'storage/', $imagePath);
    }

    $comment->user_id = auth()->user()->id;
    $comment->post_id = $post->id; // Associe o comentário à postagem correta
    $comment->save();

    return redirect()->back()->with('success', 'Comentário adicionado com sucesso.');
}

}
