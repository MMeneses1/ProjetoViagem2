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

    public $userId = null;
    public $diarioId = null;

    public function carregarMais()
    {
        $this->porPagina += 5;
        $this->render();
    }

    public function like(Post $post)
    {

        $post->likes = $post->likes + 1;
        $post->save();

        session()->flash('success', 'Post curtido com sucesso.');

        $this->dispatch('post-liked-' . $post->id); 
        return $this->render();
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
        if($this->userId != null) {
            $posts = Post::where('user_id', $this->userId)->orderBy('created_at', 'desc')->paginate($this->porPagina);
        }
        elseif($this->diarioId != null) {
            $posts = Post::where('user_id', auth()->user()->id)->where('diario_id', $this->diarioId)->orderBy('created_at', 'desc')->paginate($this->porPagina);
        }
        else {
            $posts = Post::orderBy('created_at', 'desc')->paginate($this->porPagina);
        }
        $this->noPosts = $posts->isEmpty();

        return view('livewire.posts', [
            'posts' => $posts,
        ]);
    }
}
