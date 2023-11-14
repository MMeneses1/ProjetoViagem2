<<<<<<< Updated upstream
@extends('layouts.template-inside')
@section('titulo', 'Página Inicial')
@section('css', '/css/feed.css')
@section('conteudo')

    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data" class="formulariopost">
        @csrf
        <div class="form-group">
            <textarea id="content" name="content" rows = '5' class="form-control" placeholder="Digite o texto da sua publicação" required></textarea>
            <input class="form-control-file" type="file" id="image" name="image">
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início</title>
    <link rel="stylesheet" href="/css/inicio.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
<div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Bem-vindo ao Início</h1>

                <!-- Formulário de Pesquisa -->
                <form action="{{ route('pesquisa') }}" method="GET">
                    <input type="text" id="campoPesquisa" name="query" placeholder="Pesquisar por nome ou username">
                    <button type="submit" id="pesquisarBtn" disabled>Pesquisar</button>
                </form>
                <!-- Div para Exibir Sugestões de Nomes -->
                <div id="sugestoesPesquisa"></div>

                <!-- Outros Elementos do Cabeçalho -->
                <div class="links">
                    <a href="{{ route('perfil') }}">Ver Perfil</a> | <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
>>>>>>> Stashed changes
        </div>

        <button type="submit" class="btn btn-success criarpost">Criar Publicação</button>

    </form>

    @if(!$noPosts)
    <ul role = "list" class="postslista">
        @foreach($posts->sortByDesc('created_at') as $post)
<<<<<<< Updated upstream
            <li class="postitem">
                <div class="conteudopost">
                    <div class="card post">
                        <div class="card-header">
                            <span class = "userpost">
                                @if(Auth::user()->foto_perfil)
                                    <img src="{{ asset(Auth::user()->foto_perfil) }}" alt="Foto de Perfil" class="perfilfeed">
                                @endif
                                {{ $post->user->username }} • {{ $post->created_at->diffForHumans() }}
                            </span>
=======
            <li class="post-item">
                <div class="post-container">
                    <div class="post-header">
                        <p><strong>Data da Postagem:</strong> {{ $post->created_at->diffForHumans() }}</p>
                        <p><strong>Usuário:</strong> <a href="{{ route('perfil.outro', ['username' => $post->user->username]) }}">{{ $post->user->username }}</a></p>
                    </div>
>>>>>>> Stashed changes

                            <!-- Verifique se a postagem pertence ao usuário autenticado -->
                            @if(Auth::user()->id === $post->user->id)
                                <!-- Botão de exclusão do post -->
                                <form action="{{ route('post.delete', ['post' => $post->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn">
                                        <img class = "excluirpost" src="{{ asset('images/lixeira.png') }}"/>
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
<<<<<<< Updated upstream
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
=======
                            <li class="comment-item">
                                <div class="comment-header">
                                    <p><strong>Data do Comentário:</strong> {{ $comment->created_at->diffForHumans() }}</p>
                                    <p><strong>Usuário:</strong> <a href="{{ route('perfil.outro', ['username' => $comment->user->username]) }}">{{ $comment->user->username }}</a></p>
>>>>>>> Stashed changes
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <hr/>
        @endforeach
    </ul>
@else
    <p>Nenhuma postagem foi encontrada.</p>
@endif

<<<<<<< Updated upstream
        <!-- Adicione o campo para a legenda da foto 
        <div class="form-group">
            <label for="caption">Legenda da Foto:</label>
            <input type="text" id="caption" name="caption" class="form-control" value="{{ old('caption') }}">
        </div> -->

@endsection
=======
<script>
    $(document).ready(function () {
        var campoPesquisa = $('#campoPesquisa');
        var pesquisarBtn = $('#pesquisarBtn');
        var sugestoesPesquisa = $('#sugestoesPesquisa');

        campoPesquisa.autocomplete({
            source: function (request, response) {
                // Faça a chamada AJAX para obter os resultados
                $.ajax({
                    type: 'GET',
                    url: '{{ route("pesquisa.ao.digitar") }}',
                    data: { query: request.term },
                    success: function (resultados) {
                        // Mapeie os resultados para o formato esperado pelo Autocomplete
                        var sugestoes = $.map(resultados, function (usuario) {
                            return {
                                label: usuario.nome + ' (' + usuario.username + ')',
                                value: usuario.username
                            };
                        });

                        // Forneça as sugestões para o Autocomplete
                        response(sugestoes);
                    },
                    error: function (error) {
                        console.error('Erro na chamada AJAX: ', error);
                    }
                });
            },
            minLength: 2,
            select: function (event, ui) {
                // Verifique se o usuário autenticado está acessando o próprio perfil
                if ('{{ auth()->user()->username }}' !== ui.item.value) {
                    // Redirecione para o perfil do usuário ao selecionar uma sugestão
                    window.location.href = '{{ route("perfil.outro", ["username" => ""]) }}/' + ui.item.value;
                } else {
                    // Se for o próprio usuário, redirecione para o perfil.blade.php
                    window.location.href = '{{ route("perfil") }}';
                }
            }
        });

        campoPesquisa.on('input', function () {
            // Habilitar ou desabilitar o botão com base no comprimento do texto
            pesquisarBtn.prop('disabled', campoPesquisa.val().trim().length === 0);
        });
    });
</script>



</body>
</html>
>>>>>>> Stashed changes
