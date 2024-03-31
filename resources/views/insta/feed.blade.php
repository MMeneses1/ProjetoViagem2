@extends('layouts.template-inside')
@section('titulo', 'Página Inicial')
@section('css', '/css/perfil.css')
@section('conteudo')
@include('layouts.publicacoes')

@include('insta.feedpost')

@endsection

