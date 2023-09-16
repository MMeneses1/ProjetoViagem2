@extends('layouts.app') <!-- Certifique-se de que você tenha um layout padrão definido, como 'layouts.app' -->

@section('content')
<div class="container">
    <h1>Editar Perfil</h1>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('perfil.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <!-- Resto do seu formulário -->

        <label for="username">Nome de Usuário:</label>
        <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required>

        <label for="sexo">Sexo:</label>
        <input type="text" id="sexo" name="sexo" value="{{ old('sexo', $user->sexo) }}">

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" value="{{ old('telefone', $user->telefone) }}">

        <label for="foto_perfil">Foto de Perfil:</label>
        <input type="file" id="foto_perfil" name="foto_perfil">

        <button type="submit">Atualizar Perfil</button>
    </form>
</div>
@endsection
