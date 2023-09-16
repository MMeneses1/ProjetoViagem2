<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
  

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Seu Perfil</h1>
                <p><strong>Nome:</strong> {{ Auth::user()->nome }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p><strong>Nome de Usuário:</strong> {{ Auth::user()->username }}</p>
                <p><strong>Sexo:</strong> {{ Auth::user()->sexo }}</p>
                <p><strong>Biografia:</strong> {{ Auth::user()->biografia }}</p>
                <p><strong>Telefone:</strong> {{ Auth::user()->telefone }}</p>
                <p><strong>País:</strong> {{ Auth::user()->pais }}</p>
                <p><strong>Idioma:</strong> {{ Auth::user()->idioma }}</p>
                
                <!-- Verifique se você está armazenando a foto de perfil no sistema de arquivos e tem um caminho para ela -->
                @if(Auth::user()->foto_perfil)
                    <p><strong>Foto de Perfil:</strong> <img src="{{ asset(Auth::user()->foto_perfil) }}" alt="Foto de Perfil"></p>
                @endif

                <p><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a></p>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            <a href="{{ route('insta.perfiledit') }}" class="btn btn-primary">Editar Perfil</a>
        </div>
    </div>
</body>
</html>
