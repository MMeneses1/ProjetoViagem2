<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On; 


class Posts extends Component
{
    use WithPagination;

    public $porPagina = 5;
    
    public $noPosts;
    public $loadedPosts;
    public $postsCount;
    public $postsPage;
    public $recommendations;

    public function carregarMais()
    {
        $this->porPagina += 5;
    }

    public function destroy(Post $post)
    {
        // Verifique se o usuário autenticado é o proprietário do post
        if (auth()->user()->id === $post->user_id) {
            // Exclua o post e seus comentários relacionados, se necessário
            $post->comments()->delete(); // Isso exclui todos os comentários relacionados ao post
            $post->delete();

            session()->flash('success', 'Post excluído com sucesso.');

            return $this->render();
        }
        
        session()->flash('error', 'Você não tem permissão para excluir este post.');
        return $this->render();
    }

    #[On('post-created')]
    public function render()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate($this->porPagina);
        $this->noPosts = $posts->isEmpty();



        return view('livewire.posts', [
            'posts' => $posts,
        ]);
    }
}
