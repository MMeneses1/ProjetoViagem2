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
            <li><a href="{{ route('perfil.outro', ['username' => $user->username]) }}">{{ $user->username }}</a></li>
        @endforeach
    </ul>

    @include('insta.feedpost')
@endsection