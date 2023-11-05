<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="/css/perfil.css">
</head>
<body class="text-center">
    <div class="container-fluid mx-auto">
        <div class="row">
            <a href="{{ route('login') }}" class="btn btn-primary">Ir para o Início</a>
            
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            <a href="{{ route('perfilpessoal') }}" class="btn btn-primary">Editar Perfil</a>
            <p><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a></p>

            <div class="col-lg-12 mx-auto text-center">
    <h1>Seu Perfil</h1>

    <!-- Verifique se você está armazenando a foto de perfil no sistema de arquivos e tem um caminho para ela -->
    @if(Auth::user()->foto_perfil)
        <div class="profile-picture">
            <img src="{{ asset(Auth::user()->foto_perfil) }}" alt="Foto de Perfil">
        </div>
    @endif

    <div class="profile-info">
    <p><strong>Nome de Usuário:</strong> {{Auth::user()->username}} </p>
    
    <div class="user-details">
    <p><strong>Nome:</strong> {{ Auth::user()->nome }}</p>
            <p><strong>País:</strong>
                @if(empty(Auth::user()->pais))
                    Preencha agora!
                @else
                    {{ Auth::user()->pais }}
                @endif
            </p>
        </div>
        <p><strong>Biografia:</strong>
            @if(empty(Auth::user()->biografia))
                Preencha agora!
            @else
                {{ Auth::user()->biografia }}
            @endif
        </p>
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
                    @foreach($posts as $post)
                        <li class="post-item">
                            <!-- Exiba o nome do usuário e a data da postagem -->
                            <div class="post-container">
                                <div class="post-header">
                                    <p><strong>Data da Postagem:</strong> {{ $post->created_at->diffForHumans() }}</p>
                                    <p><strong>Usuário:</strong> {{ $post->user->username }}</p>
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

                                <!-- Verifique se a postagem possui uma legenda -->
                                @if($post->caption)
                                    <p><strong>Legenda:</strong> {{ $post->caption }}</p>
                                @endif   

                                <!-- Exiba o conteúdo da postagem -->
                                <div class="post-content">
                                    <p>{{ $post->content }}</p>

                                    <!-- Verifique se a postagem possui uma imagem -->
                                    @if($post->image)
                                        <img src="{{ asset($post->image) }}" alt="Imagem da postagem">
                                    @endif
                                </div>

                                <!-- Comentários -->
                                <div class="comment-box">
                                    <h3>Comentários:</h3>
                                    <ul class="comment-list">
                                        @foreach($post->comments->sortByDesc('created_at') as $comment)
                                            <li class="comment-item">
                                                <div class="comment-header">
                                                    <p><strong>Data do Comentário:</strong> {{ $comment->created_at->diffForHumans() }}</p>
                                                    <p><strong>Usuário:</strong> {{ $comment->user->username }}</p>
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
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Nenhuma postagem encontrada.</p>
            @endif
        </div>
    </div>
</body>
</html>
