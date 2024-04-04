@extends('layouts.template-inside')
@section('titulo', 'Página Inicial')
@section('css', '/css/perfil.css')
@section('conteudo')
@include('layouts.publicacoes')




<div class="container">
    @foreach($diarioPosts as $diario)
    <div class="diario-card card mb-4">
        <div class="card-body">
            <h5 class="diario-title card-title">{{ $diario->content }}</h5>
            <!-- Adicione qualquer outra informação do diário que deseja exibir -->
            <div class="posts-wrapper row">
                @foreach($diario->posts as $post)
                <div class="post-card col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="post-content card-text">{{ $post->content }}</p>
                            <!-- Adicione qualquer outra informação do post que deseja exibir -->
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach

    <form action="{{ route('diario.store') }}" method="POST" enctype="multipart/form-data" class="formulariopost">
        @csrf
        <div class="form-group">
            <textarea id="content" name="content" rows='5' max="250" class="form-control" placeholder="Digite o texto da sua publicação" required></textarea>
            <input class="form-control" type="file" id="image" name="image">
            @for ($i = 0; $i < 3; $i++)
                <textarea id="post_content_{{ $i }}" name="post_content_{{ $i }}" rows='5' max="250" class="form-control" placeholder="Digite o texto da postagem {{ $i + 1 }}"></textarea>
            @endfor
        </div>
        <button type="submit" class="btn btn-success criarpost">Criar Publicação</button>
    </form>
</div>



<style>
.diario-card {
    display: flex;
    flex-direction: column;
    gap: 20px; /* Espaçamento entre os diários */
}

.posts-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 20px; /* Espaçamento entre os posts */
}

.post-card {
    width: calc(33.33% - 20px); /* Largura dos posts */
}

@media (max-width: 768px) {
    .post-card {
        width: calc(50% - 20px); /* Largura dos posts em telas menores */
    }
}
</style>

@endsection