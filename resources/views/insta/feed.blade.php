<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início</title>
    <link rel="stylesheet" href="/css/inicio.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Bem-vindo ao Início</h1>
                <form action="{{ route('pesquisa') }}" method="GET">
    <input type="text" name="query" placeholder="Pesquisar por nome ou username">
    <button type="submit">Pesquisar</button>
</form>

                <div class="links">
                    <a href="{{ route('perfil') }}">Ver Perfil</a> | <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data" class="post-form">
                @csrf

                <div class="form-group">
                    <label for="content">Texto da Postagem:</label>
                    <textarea id="content" name="content" class="form-control" rows="4" placeholder="Digite sua postagem aqui"></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Imagem (opcional):</label>
                    <input type="file" id="image" name="image" class="form-control-file">
                </div>

                <!-- Adicione o campo para a legenda da foto -->
                <div class="form-group">
                    <label for="caption">Legenda da Foto:</label>
                    <input type="text" id="caption" name="caption" class="form-control" value="{{ old('caption') }}">
                </div>

                <button type="submit" class="btn btn-primary">Enviar Postagem</button>
            </form>


        @if(!$noPosts)
    <h2>Seus Posts</h2>
    <ul class="post-list">
        @foreach($posts->sortByDesc('created_at') as $post)
            <li class="post-item">
                <div class="post-container">
                    <div class="post-header">
                        <p><strong>Data da Postagem:</strong> {{ $post->created_at->diffForHumans() }}</p>
                        <p><strong>Usuário:</strong> <a href="{{ route('perfil.outro', ['username' => $post->user->username]) }}">{{ $post->user->username }}</a></p>
                    </div>

                    <!-- Verifique se a postagem pertence ao usuário autenticado -->
                    @if(Auth::user()->id === $post->user->id)
                        <!-- Botão de exclusão do post -->
                        <form action="{{ route('post.delete', ['post' => $post->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir Post</button>
                        </form>
                    @endif

                    @if($post->caption)
                        <p><strong>Legenda:</strong> {{ $post->caption }}</p>
                    @endif

                    <div class="post-content">
                        @if($post->image)
                            <img src="{{ asset($post->image) }}" alt="Imagem da postagem" class="post-image">
                        @endif
                        <p>{{ $post->content }}</p>
                    </div>
                </div>

                <div class="comment-box">
                    <br>
                    <h3>Comentários:</h3>
                    <br>
                    <br>
                    <ul class="comment-list">
                        @foreach($post->comments->sortByDesc('created_at') as $comment)
                            <li class="comment-item">
                                <div class="comment-header">
                                    <p><strong>Data do Comentário:</strong> {{ $comment->created_at->diffForHumans() }}</p>
                                    <p><strong>Usuário:</strong> <a href="{{ route('perfil.outro', ['username' => $comment->user->username]) }}">{{ $comment->user->username }}</a></p>
                                </div>
                                <p class="comment-text">{{ $comment->text }}</p>

                                <!-- Botão de exclusão de comentário -->
                                @if(Auth::check() && (Auth::user()->id === $comment->user->id || Auth::user()->id === $post->user->id))
                                    <form action="{{ route('comment.delete', ['comment' => $comment->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Excluir Comentário</button>
                                    </form>
                                @endif

                                @if($comment->image)
                                    <img src="{{ asset($comment->image) }}" alt="Imagem do Comentário" class="comment-image">
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    <form action="{{ route('comment.store', ['post' => $post->id]) }}" method="POST" enctype="multipart/form-data" class="comment-form">
                        @csrf
                        <div class="form-group">
                            <label for="comment">Adicionar um Comentário:</label>
                            <textarea id="comment" name="comment" class="form-control" rows="4" placeholder="Digite seu comentário aqui"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="comment_image">Imagem do Comentário (opcional):</label>
                            <input type="file" id="comment_image" name="comment_image" class="form-control-file">
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar Comentário</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <p>Nenhuma postagem encontrada.</p>
@endif

</body>
</html>
