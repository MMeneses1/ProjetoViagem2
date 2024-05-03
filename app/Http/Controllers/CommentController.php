<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;


class CommentController extends Component
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

public function destroy(Comment $comment)
{
    // Verifique se o usuário autenticado pode excluir o comentário
    if (auth()->user()->canDeleteComment($comment)) {
        $comment->delete();
        return redirect()->back()->with('success', 'Comentário excluído com sucesso.');
    } else {
        return redirect()->back()->with('error', 'Você não tem permissão para excluir este comentário.');
    }
}

public function render(Comment $comment)
{
    $comments = $post->comments()->orderBy('created_at', 'desc')->get();

    return view('post.show', compact('post', 'comments'));
}


}
