<!-- Formulário de comentário -->
<div class="boxcomentarios">
    <!-- Lista de comentários -->
    <ul role="list" class="comentarioslista mw-100">
        <h5>Comentários</h5>
        @forelse($comments->sortByDesc('created_at') as $comment)
            <li class="comentarioitem">
                <div class="comentario">
                    <div class="header">
                        <span>
                            @if(Auth::user()->username == $comment->user->username)
                                @if(Auth::user()->foto_perfil)
                                    <img src="{{ asset(Auth::user()->foto_perfil) }}" alt="Foto de Perfil" class="perfilfeed">
                                @endif
                                <a class="linkperfil" href="{{ route('perfil') }}" wire:navigate>{{ $comment->user->username }}</a> • {{ $comment->created_at->diffForHumans() }}
                            @else
                                @if($comment->user->foto_perfil)
                                    <img src="{{ asset($comment->user->foto_perfil) }}" alt="Foto de Perfil" class="perfilfeed">
                                @endif
                                <a class="linkperfil" href="{{ route('perfil.outro', ['username' => $comment->user->username]) }}" wire:navigate>{{ $comment->user->username }}</a> • {{ $comment->created_at->diffForHumans() }}
                            @endif
                        </span>

                        <!-- Botão de exclusão de comentário -->
                        @if(Auth::check() && (Auth::user()->id === $comment->user->id || Auth::user()->id === $post->user->id))
                            <form wire:submit="destroy({{ $comment->id }})">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn">
                                    <img class="excluirpost" src="{{ asset('images/lixeira.png') }}"/>
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="conteudocomentario">
                        <p class="textocomentario">{{ $comment->text }}</p>
                        @if($comment->image)
                            <img src="{{ asset($comment->image) }}" alt="Imagem do Comentário" class="comentarioimagem d-flex">
                        @endif
                    </div>
                </div>
            </li>
        @empty
            <p>Nenhum comentário ainda.</p>
        @endforelse
        <form wire:submit="store({{ $post->id }})" enctype="multipart/form-data" class="formulariocomentario">
            @csrf
            <div class="col-md row justify-content-end">
                <div class="col-md d-flex">    
                    <textarea wire:model="comment_text" id="comment_text" name="comment_text" class="form-control" rows="1" placeholder="Escreva um comentário" required></textarea>
                </div>
                <div class="col-md-1">
                    <label for='comment_image' style='padding:0;'>
                    <img class="selecionarimagem" src="{{ asset('images/image.png') }}">
                    <input wire:model="comment_image" class="form-control-file inputfile" type="file" id="comment_image" name="comment_image">
                </label>
                </div>
                <div class="col-md-1 d-flex">
                    <button type="submit" class="btn btn-outline-success comentarpost">Comentar</button>
                </div>
                <div class="col-md-1 d-flex">
                </div>
            </div>
        </form>
    </ul>

    @script
    <script>
    var wireid = '{{$this->key}}';
    </script>
    @endscript
</div>