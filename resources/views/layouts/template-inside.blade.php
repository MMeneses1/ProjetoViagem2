<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('titulo') | Tripster</title>
    <link href="/css/template.css" rel="stylesheet">
    <link href="@yield('css')" rel="stylesheet">
    <link rel="shortcut icon" href="/images/bussola.png" type="image/icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Prompt:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">

        <nav class="navbar header">
            <div class="container">
                <a class="navbar-brand" href="login">
                    <img src="{{ asset('images/bussola.png') }}" width="25" height="25" alt="Bússola" class="d-inline-block align-text-top">
                    Tripster
                </a>
            </div>
        </nav>

        <div class = "row">
            <div class = "col-md-2">
                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ route('feed') }}">
                        <img src = "{{ asset('images/home.png') }}"/>
                        Início
                    </a>
                    <a class="nav-link" href="{{ route('perfil') }}">
                        @if(Auth::user()->foto_perfil)
                            <img src="{{ asset(Auth::user()->foto_perfil) }}" alt="Foto de Perfil" class="fotoperfil">
                        @endif
                        Meu Perfil
                    </a>
                    <a class="nav-link" href="{{ route('insta.perfiledit') }}">
                        <img src = "{{ asset('images/config.png') }}"/>
                        Configurações
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <img src = "{{ asset('images/sair.png') }}"/>
                        Sair
                    </a>
                </nav>
            </div>

            <div class = "col-md-7">
                @yield('conteudo')
            </div>

            <div class = "col-md-3">
                <h3>Tripsters</h3>
                <div class="input-group">
                    <form action="{{ route('pesquisa') }}" method="GET" class = "formulariopesquisar">
                        <input type="text" class="form-control" name = "query" placeholder="Nome ou usuário" aria-label="Recipient's username" aria-describedby="pesquisar">
                        <button class="btn" type="submit" id="pesquisar">
                            <img class = "botaopesquisar" src = "{{ asset('images/lupa.png') }}"/>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
