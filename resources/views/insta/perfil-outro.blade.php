@extends('layouts.template-inside')
@section('titulo', $otherUser->username)
@section('css', '/css/perfil.css')
@section('conteudo')

<div @if($posts->isEmpty()) style="height: 100vh" @endif>
    <div class = "profileinfo">
        @if($otherUser->foto_perfil)
            <div class="profilepicture">
                <img src="{{ asset($otherUser->foto_perfil) }}" alt="Foto de Perfil" class="profileimage">
            </div>
        @endif

        <div class="userdetails">
            <p class = "info">{{ $otherUser->name }} • {{ $otherUser->username }}</p>

            @if($otherUser->pais)
                <p class = "info">{{ $otherUser->pais }}</p>
            @endif

            @if($otherUser->biografia)
                <p class = "info">{{ $otherUser->biografia }}</p>
            @endif

            @if(auth()->user()->isFollowing($otherUser))
                <!-- Botão para deixar de seguir -->
                <form action="{{ route('perfil.deixar-de-seguir', ['username' => $otherUser->username]) }}" method="POST">
                    @csrf
                    <button class = "btn btn-outline-success" type="submit">Deixar de Seguir</button>
                </form>
                @elseif(auth()->user()->id !== $otherUser->id)
                <!-- Botão para seguir -->
                <form action="{{ route('perfil.seguir', ['username' => $otherUser->username]) }}" method="POST">
                    @csrf
                    <button class = "btn btn-success" type="submit">Seguir</button>
                </form>
            @endif
        </div>
    </div>

    @if(!$posts->isEmpty())
    <ul role="list" class="postslista">
        @foreach($posts->sortByDesc('created_at') as $post)
            <li class="postitem">
                <div class="conteudopost">
                    <div class="card post">
                        <div class="card-header header">
                            <span class="userpost">
                                @if($otherUser->foto_perfil)
                                    <img src="{{ asset($otherUser->foto_perfil) }}" alt="Foto de Perfil" class="perfilfeed">
                                @endif

                                <a class = "linkperfil" href="{{ route('perfil') }}">{{ $post->user->username }}</a> • {{ $post->created_at->diffForHumans() }}
                            </span>
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

                <div class = "boxcomentarios">
                    <form action="{{ route('comment.store', ['post' => $post->id]) }}" method="POST" enctype="multipart/form-data" class="formulariocomentario">
                        @csrf
                        <div class="form-group groupcomentario">
                            <textarea id="comment" name="comment" class="form-control" rows="1" placeholder="Escreva um comentário" required></textarea>
                            <label for = 'comment_image'>
                                <img class = "selecionarimagem" src = "{{ asset('images/image.png') }}">
                            </label>
                            <input class = "inputfile" type="file" id="comment_image" name="comment_image" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-outline-success comentarpost">Comentar</button>
                    </form>
                    <ul role = "list" class="comentarioslista">
                        <h5>Comentários</h5>
                            <li class="comentarioitem">
                                @foreach($post->comments->sortByDesc('created_at') as $comment)
                                <div class="comentario">
                                    <div class="header">
                                        <span>
                                            @if(Auth::user()->username == $comment->user->username)
                                                @if(Auth::user()->foto_perfil)
                                                    <img src="{{ asset(Auth::user()->foto_perfil) }}" alt="Foto de Perfil" class="perfilfeed">
                                                @endif
                                                <a class = "linkperfil" href="{{ route('perfil') }}">{{ $comment->user->username }}</a> • {{ $comment->created_at->diffForHumans() }}
                                            @else
                                                @if($post->user->foto_perfil)
                                                    <img src="{{ asset($post->user->foto_perfil) }}" alt="Foto de Perfil" class="perfilfeed">
                                                @endif
                                                <a class = "linkperfil" href="{{ route('perfil.outro', ['username' => $post->user->username]) }}">{{ $post->user->username }}</a> • {{ $post->created_at->diffForHumans() }}
                                            @endif
                                        </span>
                                        
                                        <!-- Botão de exclusão de comentário -->
                                        @if(Auth::check() && (Auth::user()->id === $comment->user->id || Auth::user()->id === $post->user->id))
                                            <form action="{{ route('comment.delete', ['comment' => $comment->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn">
                                                    <img class = "excluirpost" src="{{ asset('images/lixeira.png') }}"/>
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
                        @endforeach
                    </ul>
                </div>


            </li>
        @endforeach
    </ul>
    @else
        <p>Nenhuma postagem encontrada.</p>
    @endif
</div>
@endsection