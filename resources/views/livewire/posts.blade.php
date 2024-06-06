<div>
    @if(!$noPosts)
    <ul role="list" class="postslista">
        @foreach($posts->sortByDesc('created_at') as $index => $post)
            <li wire:key="{{ $post->id }}" class="postitem">
                <div class="conteudopost">
                    <div class="card post">
                        <div class="card-header header">
                            <span class="userpost">
                                @if(Auth::user()->username == $post->user->username)
                                    @if(Auth::user()->foto_perfil)
                                        <img src="{{ asset(Auth::user()->foto_perfil) }}" alt="Foto de Perfil" class="perfilfeed">
                                    @endif
                                    <a class = "linkperfil" href="{{ route('perfil') }}" wire:navigate>{{ $post->user->username }}</a> • {{ $post->created_at->diffForHumans() }}
                                @else
                                    @if($post->user->foto_perfil)
                                        <img src="{{ asset($post->user->foto_perfil) }}" alt="Foto de Perfil" class="perfilfeed">
                                    @endif
                                    <a class = "linkperfil" href="{{ route('perfil.outro', ['username' => $post->user->username]) }}" wire:navigate>{{ $post->user->username }}</a> • {{ $post->created_at->diffForHumans() }}
                                @endif
                            </span>

                            <!-- Verifique se a postagem pertence ao usuário autenticado -->
                            @if(Auth::user()->id === $post->user->id)
                                <!-- Botão de exclusão do post -->
                                <form wire:submit="destroy({{ $post }})">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn">
                                        <img class="excluirpost" src="{{ asset('images/lixeira.png') }}"/>
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="card-body">
                            <p class="textopost">{{ $post->content }}</p>
                            @if($post->image)
                                <div class="imagempost">
                                    <img src="{{ asset($post->image) }}" alt="Imagem da postagem">
                                </div>
                            @endif
                        </div>

                        <!-- Botão para mostrar/esconder comentários -->
                        <button class="mostrar-comentarios-btn btn btn-link">Mostrar Comentários</button>

                        <!-- Formulário de comentário (inicialmente oculto) -->
                        <div class="boxcomentarios" style="display: none;">
                            <form action="{{ route('comment.store', ['post' => $post->id]) }}" method="POST" enctype="multipart/form-data" class="formulariocomentario">
                                @csrf
                                <div class="form-group groupcomentario">
                                    <textarea id="comment" name="comment" class="form-control" rows="1" placeholder="Escreva um comentário" required></textarea>
                                    <label for='comment_image'>
                                        <img class="selecionarimagem" src="{{ asset('images/image.png') }}">
                                    </label>
                                    <input class="form-control-file inputfile" type="file" id="comment_image" name="comment_image">
                                </div>
                                <button type="submit" class="btn btn-outline-success comentarpost">Comentar</button>
                            </form>

                            <!-- Lista de comentários -->
                            <ul role="list" class="comentarioslista">
                                <h5>Comentários</h5>
                                @forelse($post->comments->sortByDesc('created_at') as $comment)
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
                                                    <form action="{{ route('comment.delete', ['comment' => $comment->id]) }}" method="POST">
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
                                                    <img src="{{ asset($comment->image) }}" alt="Imagem do Comentário" class="comentarioimagem">
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <p>Nenhum comentário ainda.</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <hr/>
        @endforeach
        <div
            x-data="{
                observe () {
                    let observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                @this.call('carregarMais')
                            }
                        })
                    }, {
                        root: null
                    })

                    observer.observe(this.$el)
                }
            }"
            x-init="observe"
        ></div>
    </ul>
       
    @else
        <p>Nenhuma publicação foi encontrada.</p>
    @endif
</div>