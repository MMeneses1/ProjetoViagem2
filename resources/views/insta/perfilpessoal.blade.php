<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados pessoais</title>
    <link rel="stylesheet" href="/css/perfil.css">
</head>
<body class="text-center">
    <div class="container-fluid mx-auto">
        <div class="row">

            <div class="col-lg-12 mx-auto">
            <a href="{{ route('perfil') }}" class="btn btn-primary">Voltar Perfil</a>
                <h1>Seus Dados</h1>

                <!-- Verifique se você está armazenando a foto de perfil no sistema de arquivos e tem um caminho para ela -->
                @if(Auth::user()->foto_perfil)
    <div class="profile-picture">
        <img src="{{ asset(Auth::user()->foto_perfil) }}" alt="Foto de Perfil" class="profile-image">
    </div>
@endif

                <p><strong>Nome:</strong> {{ Auth::user()->nome }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p><strong>Nome de Usuário:</strong>
                    @if(empty(Auth::user()->username))
                        Preencha agora!
                    @else
                        {{ Auth::user()->username }}
                    @endif
                </p>
                <p><strong>Sexo:</strong>
                    @if(empty(Auth::user()->sexo))
                        Preencha agora!
                    @else
                        {{ Auth::user()->sexo }}
                    @endif
                </p>
                <p><strong>Biografia:</strong>
                    @if(empty(Auth::user()->biografia))
                        Preencha agora!
                    @else
                        {{ Auth::user()->biografia }}
                    @endif
                </p>
                <p><strong>Telefone:</strong>
                    @if(empty(Auth::user()->telefone))
                        Preencha agora!
                    @else
                        {{ Auth::user()->telefone }}
                    @endif
                </p>
                <p><strong>País:</strong>
                    @if(empty(Auth::user()->pais))
                        Preencha agora!
                    @else
                        {{ Auth::user()->pais }}
                    @endif
                </p>
                <p><strong>Idioma:</strong>
                    @if(empty(Auth::user()->idioma))
                        Preencha agora!
                    @else
                        {{ Auth::user()->idioma }}
                    @endif
                </p>
                <p><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a></p>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="{{ route('insta.perfiledit') }}" class="btn btn-primary">Editar Perfil</a>
            </div>
        </div>
    </div>
</body>
</html>
