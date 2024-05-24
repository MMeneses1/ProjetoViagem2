<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Post;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;


class Publicacoes extends Component
{
    use WithFileUploads;
    
    #[Validate('nullable|string|max:255')] 
    public $content = '';

    #[Validate('nullable|image|mimes:jpeg,png,jpg,gif|max:2048')] 
    public $image;

    #[Validate('nullable|string|max:255')] 
    public $caption = '';

    public function store()
    {

        $post = new Post();
        $post->content = $this->content;

        if ($this->image) {
            $imagePath = $this->image->store('public/images');
            $post->image = str_replace('public/', 'storage/', $imagePath);
        }

        // Salvar a legenda
        $post->caption = $this->caption;

        $post->user_id = auth()->user()->id;
        $post->save();

        session()->flash('success', 'Postagem criada com sucesso.');

        $this->reset();

        return $this->dispatch('post-created');
    }

    public function render()
    {
        return view('livewire.publicacoes');
    }
}
