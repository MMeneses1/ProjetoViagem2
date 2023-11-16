@extends('layouts.template-inside')
@section('titulo', 'Página Inicial')
@section('css', '/css/perfil.css')
@section('conteudo')

<div @if($noPosts) style="height: 100vh" @endif>
    @include('layouts.publicacoes')
    <!-- Adicione o formulário para carregar mais posts -->
    @if($postsCount > 5)
        <form action="{{ route('load.more.posts', ['loadedPosts' => $loadedPosts]) }}" method="GET" id="loadMoreForm">
            @csrf
            <button type="submit" class="btn btn-success">Carregar Mais</button>
        </form>
    @endif
</div>
@endsection