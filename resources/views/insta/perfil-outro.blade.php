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
            </li>
        @endforeach
    </ul>
    @else
        <p>Nenhuma postagem encontrada.</p>
    @endif
</div>
@endsection