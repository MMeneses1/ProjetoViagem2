<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Seu Perfil</h1>
                <p><strong>Nome:</strong> {{ Auth::user()->nome }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p><strong>Nome de Usuário:</strong>
                    @if(empty(Auth::user()->username))
                        Preencha agora!
                    @else
                        {{ Auth::user()->username }}
                    @endif
                </p>
                <p><strong>Sexo:</strong>
                    @if(empty(Auth::user()->sexo))
                        Preencha agora!
                    @else
                        {{ Auth::user()->sexo }}
                    @endif
                </p>
                <p><strong>Biografia:</strong>
                    @if(empty(Auth::user()->biografia))
                        Preencha agora!
                    @else
                        {{ Auth::user()->biografia }}
                    @endif
                </p>
                <p><strong>Telefone:</strong>
                    @if(empty(Auth::user()->telefone))
                        Preencha agora!
                    @else
                        {{ Auth::user()->telefone }}
                    @endif
                </p>
                <p><strong>País:</strong>
                    @if(empty(Auth::user()->pais))
                        Preencha agora!
                    @else
                        {{ Auth::user()->pais }}
                    @endif
                </p>
                <p><strong>Idioma:</strong>
                    @if(empty(Auth::user()->idioma))
                        Preencha agora!
                    @else
                        {{ Auth::user()->idioma }}
                    @endif
                </p>

                <!-- Verifique se você está armazenando a foto de perfil no sistema de arquivos e tem um caminho para ela -->
                @if(Auth::user()->foto_perfil)
                    <p><strong>Foto de Perfil:</strong></p>
                    <img src="{{ asset(Auth::user()->foto_perfil) }}" alt="Foto de Perfil">
                @endif

                <p><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a></p>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            <a href="{{ route('insta.perfiledit') }}" class="btn btn-primary">Editar Perfil</a>

            <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="content">Texto da Postagem:</label>
                    <textarea id="content" name="content" class="form-control" rows="4" placeholder="Digite sua postagem aqui" ></textarea>
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
    <ul>
        @foreach($posts as $post)
            <li>
                <!-- Exiba o conteúdo da postagem -->
                <p>{{ $post->content }}</p>
                
                <!-- Verifique se a postagem possui uma imagem -->
                @if($post->image)
                    <p><strong>Imagem da Postagem:</strong></p>
                    <img src="{{ asset($post->image) }}" alt="Imagem da postagem">
                @endif

                <!-- Verifique se a postagem possui uma legenda -->
                @if($post->caption)
                    <p><strong>Legenda:</strong> {{ $post->caption }}</p>
                @endif

                <!-- Exibir os comentários -->
                <h3>Comentários:</h3>
                <ul>
                    @foreach($post->comments as $comment)
                        <li>
                            <!-- Exiba o texto do comentário -->
                            <p>{{ $comment->text }}</p>
                            
                            <!-- Verifique se o comentário possui uma imagem -->
                            @if($comment->image)
                <p><strong>Imagem do Comentário:</strong></p>
                <img src="{{ asset($comment->image) }}" alt="Imagem do Comentário">
            @endif
                        </li>
                    @endforeach
                </ul>

                <!-- Formulário para adicionar comentários -->
                <form action="{{ route('comment.store', ['post' => $post->id]) }}" method="POST" enctype="multipart/form-data">
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
    </div>
</body>
</html>
