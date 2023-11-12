

@section('css', '/css/login.css')
@section('conteudo')
    <div class="container-fluid mx-auto">
        <div class="row">
            <a href="{{ route('feed') }}" class="btn btn-primary">Ir para o Início</a>
        </div>

        <div class="col-lg-12 mx-auto text-center">
            <h1>Perfil de {{ $otherUser->username }}</h1>

            @if($otherUser->foto_perfil)
                <div class="profile-picture">
                    <img src="{{ asset($otherUser->foto_perfil) }}" alt="Foto de Perfil" class="profile-image">
                </div>
            @endif

            <div class="profile-info">
                <p><strong>Nome de Usuário:</strong> {{ $otherUser->username }}</p>

                <div class="user-details">
                    <p><strong>Nome:</strong> {{ $otherUser->nome }}</p>
                    <p><strong>País:</strong>
                        @if(empty($otherUser->pais))
                            Não disponível
                        @else
                            {{ $otherUser->pais }}
                        @endif
                    </p>
                </div>

                <p><strong>Biografia:</strong>
                    @if(empty($otherUser->biografia))
                        Não disponível
                    @else
                        {{ $otherUser->biografia }}
                    @endif
                </p>
            </div>
        </div>

        @if(!$posts->isEmpty())
            <h2>Posts de {{ $otherUser->username }}</h2>
            <ul class="post-list">
                @foreach($posts as $post)
                    <li class="post-item">
                        <div class="post-container">
                            <div class="post-header">
                                <p><strong>Data da Postagem:</strong> {{ $post->created_at->diffForHumans() }}</p>
                                <p><strong>Usuário:</strong> {{ $post->user->username }}</p>
                            </div>

                            <!-- Adicione apenas a visualização do post, sem capacidade de exclusão -->
                            <div class="post-content">
                                <p>{{ $post->content }}</p>

                                @if($post->image)
                                    <img src="{{ asset($post->image) }}" alt="Imagem da postagem">
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Nenhuma postagem encontrada.</p>
        @endif
    </div>
</body>
</html>
