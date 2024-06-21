<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Spatie\MediaLibraryPro\Livewire\Concerns\WithMedia;
use Livewire\WithFileUploads;

class Comments extends Component
{
    use WithFileUploads;

    public $post;

    public $key;
    public $postId;

    #[Validate('nullable|string|max:255')] 
    public $comment_text='';
    #[Validate('nullable|image|mimes:jpeg,png,jpg,gif|max:2048')] 
    public $comment_image;

    public function render()
    {
        $post = Post::find($this->postId);
        $comments = $post->comments()->orderBy('created_at', 'desc')->get();

        return view('livewire.comments', [
            'comments' => $comments,
            'post' => $post,
        ]);
    }

        public function store(Request $request, Post $post)
    {

        $comment = new Comment();
        $comment->text = $this->comment_text;

        if ($this->comment_image) {
            $imagePath = $this->comment_image->store('public/comment_images');
            $comment->image = str_replace('public/', 'storage/', $imagePath);
        }

        $comment->user_id = auth()->user()->id;
        $comment->post_id = $post->id; // Associa o comentário à postagem correta
        $comment->save();

        $this->comment_text = '';
        $this->comment_image = NULL;

        session()->flash('success', 'Comentário adicionado com sucesso.');
        return $this->render();
    }

    public function destroy(Comment $comment)
    {
        // Verifique se o usuário autenticado pode excluir o comentário
        if (auth()->user()->canDeleteComment($comment)) {
            $comment->delete();
            session()->flash('success', 'Comentário excluído com sucesso.');
            return $this->render();
        } else {
            session()->flash('error', 'Você não tem permissão para excluir este comentário.');
            return $this->render();
        }
    }
}
