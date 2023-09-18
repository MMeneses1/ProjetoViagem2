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
                <div class="links">
                    <a href="{{ route('perfil') }}">Ver Perfil</a> | <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        @if(!$noPosts)
        <h2>Seus Posts</h2>
        <ul class="post-list">
            @foreach($posts as $post)
                <li class="post-item">
                    <div class="post-header">
                        <p><strong>Usuário:</strong> {{ $post->user->username }}</p>
                        <p><strong>Data da Postagem:</strong> {{ $post->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>

                    @if($post->caption)
                        <p><strong>Legenda:</strong> {{ $post->caption }}</p>
                    @endif

                    <p class="post-content">{{ $post->content }}</p>

                    @if($post->image)
                        <img src="{{ asset($post->image) }}" alt="Imagem da postagem" class="post-image">
                    @endif

                    <div class="comment-box">
                        <h3>Comentários:</h3>
                        <ul class="comment-list">
                            @foreach($post->comments as $comment)
                                <li class="comment-item">
                                    <div class="comment-header">
                                        <p><strong>Usuário:</strong> {{ $post->user->username }}</p>
                                        <p><strong>Data da Postagem:</strong> {{ $post->created_at->format('d/m/Y H:i:s') }}</p>
                                    </div>
                                    <p class="comment-text">{{ $comment->text }}</p>
                                    @if($comment->image)
                                        <img src="{{ asset($comment->image) }}" alt="Imagem do Comentário" class="comment-image">
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>

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
                </li>
            @endforeach
        </ul>
        @else
            <p>Nenhuma postagem encontrada.</p>
        @endif
    </div>
</body>
</html>
