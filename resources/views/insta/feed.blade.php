    @extends('layouts.template-inside')
    @section('titulo', 'Página Inicial')
    @section('css', '/css/perfil.css')
    @section('conteudo')
        @livewire('Publicacoes')

        <!-- Conteúdo da página inicial -->

        <!-- Exibição das recomendações -->
        @if (!$recommendations->isEmpty())
        <h5>Recomendações de Usuários</h5>
        @endif
        <ul>
            @foreach ($recommendations as $user)
                <li>
                    <img src="{{ $user->foto_perfil }}" alt="{{ $user->username }}" width="50" height="50" style="border-radius: 50%;">
                    <a href="{{ route('perfil.outro', ['username' => $user->username]) }}" wire:navigate>{{ $user->username }}</a>
                </li>
            @endforeach
        </ul>

        <h5>Publicações</h5>
        <livewire:feedpost />
    @endsection