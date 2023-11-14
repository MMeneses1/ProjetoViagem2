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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                    <input type="text" id="campoPesquisa" name="query" placeholder="Pesquisar por nome ou username" class="form-control" aria-label="Recipient's username" aria-describedby="pesquisar">
                    <button   class="btn" type="submit" id="pesquisarBtn" disabled>
                    <img class = "botaopesquisar" src = "{{ asset('images/lupa.png') }}"/>
                    </button>
                    </form>
                
                <div id="sugestoesPesquisa"></div>               
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        var campoPesquisa = $('#campoPesquisa');
        var pesquisarBtn = $('#pesquisarBtn');
        var sugestoesPesquisa = $('#sugestoesPesquisa');

        campoPesquisa.autocomplete({
            source: function (request, response) {
                // Faça a chamada AJAX para obter os resultados
                $.ajax({
                    type: 'GET',
                    url: '{{ route("pesquisa.ao.digitar") }}',
                    data: { query: request.term },
                    success: function (resultados) {
                        // Mapeie os resultados para o formato esperado pelo Autocomplete
                        var sugestoes = $.map(resultados, function (usuario) {
                            return {
                                label: usuario.nome + ' (' + usuario.username + ')',
                                value: usuario.username
                            };
                        });

                        // Forneça as sugestões para o Autocomplete
                        response(sugestoes);
                    },
                    error: function (error) {
                        console.error('Erro na chamada AJAX: ', error);
                    }
                });
            },
            
            select: function (event, ui) {
                // Verifique se o usuário autenticado está acessando o próprio perfil
                if ('{{ auth()->user()->username }}' !== ui.item.value) {
                    // Redirecione para o perfil do usuário ao selecionar uma sugestão
                    window.location.href = '{{ route("perfil.outro", ["username" => ""]) }}/' + ui.item.value;
                } else {
                    // Se for o próprio usuário, redirecione para o perfil.blade.php
                    window.location.href = '{{ route("perfil") }}';
                }
            }
        });

        campoPesquisa.on('input', function () {
            // Habilitar ou desabilitar o botão com base no comprimento do texto
            pesquisarBtn.prop('disabled', campoPesquisa.val().trim().length === 0);
        });
    });
</script>

</body>
</html>
