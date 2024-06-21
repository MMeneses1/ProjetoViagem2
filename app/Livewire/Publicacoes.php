<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Post;
use App\Models\Diario;
use App\Models\Pagina;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;


class Publicacoes extends Component
{
    use WithFileUploads;

    #[Validate('nullable|string|max:255')] 
    public $content1 = '';
    #[Validate('nullable|string|max:255')] 
    public $content2 = '';
    #[Validate('nullable|string|max:255')] 
    public $content3 = '';

    #[Validate('nullable|image|mimes:jpeg,png,jpg,gif|max:2048')] 
    public $image1;
    #[Validate('nullable|image|mimes:jpeg,png,jpg,gif|max:2048')] 
    public $image2;
    #[Validate('nullable|image|mimes:jpeg,png,jpg,gif|max:2048')] 
    public $image3;

    public $album = '';
    public $quantidade = 1;
    public $tipo1 = "imagem";
    public $tipo2 = "texto";
    public $tipo3 = "texto";

    public function store()
    {
        $diario = Diario::where('content', $this->album)->where('user_id', auth()->user()->id)->first();
        if($diario === NULL) {
            $diario = new Diario();
            $diario->content = $this->album;
            $diario->user_id = auth()->user()->id;
            $diario->save();
        }

        $post = new Post();
        $post->user_id = auth()->user()->id;
        $post->diario_id = $diario->id;
        $post->save();
        
        $pagina1 = new Pagina();
        $pagina1->content = $this->content1;
        if ($this->image1) {
            $imagePath = $this->image1->store('public/images');
            $pagina1->image = str_replace('public/', 'storage/', $imagePath);
        }
        $pagina1->post_id = $post->id;
        $pagina1->save();

        if(!empty($this->content2) || !empty($this->image2)) {
            $pagina2 = new Pagina();

            $pagina2->content = $this->content2;
            if ($this->image2) {
                $imagePath = $this->image2->store('public/images');
                $pagina2->image = str_replace('public/', 'storage/', $imagePath);
            }
            $pagina2->post_id = $post->id;
            $pagina2->save();
        }

        if(!empty($this->content3) || !empty($this->image3)) {
            $pagina3 = new Pagina();

            $pagina3->content = $this->content3;
            if ($this->image3) {
                $imagePath = $this->image3->store('public/images');
                $pagina3->image = str_replace('public/', 'storage/', $imagePath);
            }
            $pagina3->post_id = $post->id;
            $pagina3->save();
        }

        $post->save();


        session()->flash('success', 'Postagem criada com sucesso.');

        $this->content1 = '';
        $this->content2 = '';
        $this->content3 = '';

        $this->image1;
        $this->image2;
        $this->image3;

        $this->album = '';
        $this->quantidade = 1;
        $this->tipo1 = "imagem";
        $this->tipo2 = "texto";
        $this->tipo3 = "texto";

        $this->render();
        return $this->dispatch('post-created');
    }

    public function render()
    {
        return view('livewire.publicacoes');
    }
}
