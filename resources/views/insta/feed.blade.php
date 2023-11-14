@extends('layouts.template-inside')
@section('titulo', 'Página Inicial')
@section('css', '/css/feed.css')
@section('conteudo')

    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data" class="formulariopost">
        @csrf
        <div class="form-group">
            <textarea id="content" name="content" rows = '5' class="form-control" placeholder="Digite o texto da sua publicação" required></textarea>
            <input class="form-control-file" type="file" id="image" name="image">
        </div>

        <button type="submit" class="btn btn-success criarpost">Criar Publicação</button>

    </form>

    @if(!$noPosts)
    <ul role="list" class="postslista">
        @foreach($posts->sortByDesc('created_at') as $post)
            <li class="postitem">
                <div class="conteudopost">
                    <div class="card post">
                        <div class="card-header">
                            <span class="userpost">
                                @if(Auth::user()->foto_perfil)
                                    <img src="{{ asset(Auth::user()->foto_perfil) }}" alt="Foto de Perfil" class="perfilfeed">
                                @endif
                                {{ $post->user->username }} • {{ $post->created_at->diffForHumans() }}
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


                    <!-- @if($post->caption)
                        <p><strong>Legenda:</strong> {{ $post->caption }}</p>
                    @endif-->

                <div class="conteudocomentario">
                    <form action="{{ route('comment.store', ['post' => $post->id]) }}" method="POST" enctype="multipart/form-data" class="formulariocomentario">
                        @csrf
                        <div class="form-group">
                            <textarea id="comment" name="comment" class="form-control" rows="1" placeholder="Escreva um comentário" required></textarea>
                        </div>
                        <div class="form-group">
                            <input type="file" id="comment_image" name="comment_image" class="form-control-file">
                        </div>
                        <button type="submit" class="btn me-md-2 btn-outline-success comentarpost">Comentar</button>
                    </form>
                    <ul role = "list" class="comentarioslista">
                        @foreach($post->comments->sortByDesc('created_at') as $comment)
                            <li class="comentarioitem">
                                <div class="card comentario">
                                    <div class="card-header">
                                        <span>
                                            @if(Auth::user()->foto_perfil)
                                                <img src="{{ asset(Auth::user()->foto_perfil) }}" alt="Foto de Perfil" class="perfilfeed">
                                            @endif
                                            {{ $comment->user->username }} • {{ $comment->created_at->diffForHumans() }}
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
                                    <div class="card-body">
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
            <hr/>
        @endforeach
    </ul>

    <!-- Adicione o formulário para carregar mais posts -->
    <form action="{{ route('load.more.posts', ['loadedPosts' => $loadedPosts]) }}" method="GET" id="loadMoreForm">
    @csrf
    <button type="submit" class="btn btn-primary">Carregar Mais</button>
</form>



@else
    <p>Nenhuma postagem foi encontrada.</p>
@endif

        <!-- Adicione o campo para a legenda da foto 
        <div class="form-group">
            <label for="caption">Legenda da Foto:</label>
            <input type="text" id="caption" name="caption" class="form-control" value="{{ old('caption') }}">
        </div> -->

@endsection



</body>
</html>
