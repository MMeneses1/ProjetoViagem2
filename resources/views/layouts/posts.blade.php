@if(!$noPosts)
    <ul role="list" class="postslista">
    @foreach($posts->sortByDesc('created_at') as $index => $post)
        <li class="postitem" @if($loop->last) id="ultimoPost" @endif>
                <div class="conteudopost">
                    <div class="card post">
                        <div class="card-header header">
                            <span class="userpost">
                                @if(Auth::user()->username == $post->user->username)
                                    @if(Auth::user()->foto_perfil)
                                        <img src="{{ asset(Auth::user()->foto_perfil) }}" alt="Foto de Perfil" class="perfilfeed">
                                    @endif
                                    <a class = "linkperfil" href="{{ route('perfil') }}">{{ $post->user->username }}</a> • {{ $post->created_at->diffForHumans() }}
                                @else
                                    @if($post->user->foto_perfil)
                                        <img src="{{ asset($post->user->foto_perfil) }}" alt="Foto de Perfil" class="perfilfeed">
                                    @endif
                                    <a class = "linkperfil" href="{{ route('perfil.outro', ['username' => $post->user->username]) }}">{{ $post->user->username }}</a> • {{ $post->created_at->diffForHumans() }}
                                @endif
                            </span>

                            <!-- Verifique se a postagem pertence ao usuário autenticado -->
                            @if(Auth::user()->id === $post->user->id)
                                <!-- Botão de exclusão do post -->
                                <form action="{{ route('post.delete', ['post' => $post->id]) }}" method="POST">
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
                    </div>
                </div>

            </li>
            <hr/>
        @endforeach
    </ul>

    @else
        <p>Nenhuma publicação foi encontrada.</p>
    @endif
