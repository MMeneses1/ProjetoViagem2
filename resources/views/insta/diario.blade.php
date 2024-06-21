
    @extends('layouts.template-inside')
    @section('titulo', 'Página Inicial')
    @section('css', '/css/perfil.css')
    @section('conteudo')
    
    <livewire:publicacoes />

    <div class="container">
        @foreach($diarioPosts as $diario)
            <h2 style="text-align: center;">{{$diario->content}}</h2>
            <livewire:posts :diarioId="$diario->id" />
        @endforeach
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