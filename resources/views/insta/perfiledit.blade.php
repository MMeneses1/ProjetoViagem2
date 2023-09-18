<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('inc.topo')

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

            <div class="form-group">
                <label for="username">Nome de Usuário:</label>
                <input type="text" id="username" name="username" value="{{ old('username', Auth::user()->username) }}" required>
            </div>

            <div class="form-group">
                <label for="sexo">Sexo:</label>
                <input type="text" id="sexo" name="sexo" value="{{ old('sexo', Auth::user()->sexo) }}">
            </div>

            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" value="{{ old('telefone', Auth::user()->telefone) }}">
            </div>

            <div class="form-group">
                <label for="foto_perfil">Foto de Perfil:</label>
                <input type="file" id="foto_perfil" name="foto_perfil">
            </div>

            <div class="form-group">
                <label for="biografia">Biografia:</label>
                <textarea id="biografia" name="biografia">{{ old('biografia', Auth::user()->biografia) }}</textarea>
            </div>

            <div class="form-group">
                <label for="idioma">Idioma:</label>
                <input type="text" id="idioma" name="idioma" value="{{ old('idioma', Auth::user()->idioma) }}">
            </div>

            <button type="submit" class="btn btn-primary">Atualizar Perfil</button>

            <a href="{{ route('perfilpessoal') }}" class="btn btn-primary">Voltar</a>
        </form>
    </div>
</body>
</html>
