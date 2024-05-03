<div>
    @extends('layouts.template-inside')
    @section('titulo', 'Página Inicial')
    @section('css', '/css/perfil.css')
    @section('conteudo')
        @include('layouts.publicacoes')

        <!-- Conteúdo da página inicial -->

        <!-- Exibição das recomendações -->
        <h2>Recomendações de Usuários</h2>
        <ul>
            @foreach ($recommendations as $user)
                <li>
                    <img src="{{ $user->foto_perfil }}" alt="{{ $user->username }}" width="50" height="50">
                    <a href="{{ route('perfil.outro', ['username' => $user->username]) }}" wire:navigate>{{ $user->username }}</a>
                </li>
            @endforeach
        </ul>

        @include('insta.feedpost')
    @endsection
</div>