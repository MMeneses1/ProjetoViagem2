@extends('layouts.template-inside')
@section('titulo', 'Página Inicial')
@section('css', '/css/perfil.css')
@section('conteudo')

<div @if($noPosts) style="height: 100vh" @endif>
    @include('layouts.publicacoes')
</div>
@endsection