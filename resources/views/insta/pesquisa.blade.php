<div> 
    <div class="row">
        <a href="{{ route('feed') }}" class="btn btn-primary" wire:navigate>Ir para o Início</a>
    </div>

    <form id="formPesquisa" action="{{ route('pesquisa') }}" method="GET">
        <input type="text" id="campoPesquisa" name="query" placeholder="Pesquisar por nome ou username">
        <button type="submit" id="pesquisarBtn" disabled>Pesquisar</button>
    </form>

    <div id="resultadosPesquisa">
        @if($resultados->isNotEmpty())
            <p>Encontrado(s) {{ $resultados->count() }} usuário(s) com o nome "{{ $query }}".</p>
            <ul>
                @foreach($resultados as $usuario)
                <li>
        <a href="{{ Auth::user()->username == $usuario->username ? route('perfil') : route('perfil.outro', ['username' => $usuario->username]) }}" wire:navigate>
            {{ $usuario->nome }} ({{ $usuario->username }})
        </a>
    </li>
                @endforeach
            </ul>


        @else
            <p>Nenhum usuário encontrado.</p>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            var formPesquisa = $('#formPesquisa');
            var campoPesquisa = $('#campoPesquisa');
            var resultadosPesquisa = $('#resultadosPesquisa');
            var pesquisarBtn = $('#pesquisarBtn');

            campoPesquisa.on('input', function () {
                var query = campoPesquisa.val().trim();

                // Verifique se a consulta não está vazia
                if (query !== '') {
                    pesquisarBtn.prop('disabled', false); // Ativa o botão
                    // Faça a chamada AJAX para obter os resultados
                    $.ajax({
                        type: 'GET',
                        url: '{{ route("pesquisa.ao.digitar") }}',
                        data: { query: query },
                        success: function (resultados) {
                            // Atualize a lista de resultados na página
                            resultadosPesquisa.html('');
                            if (resultados.length > 0) {
                                resultadosPesquisa.append('<p>Resultados da Pesquisa:</p>');
                                resultadosPesquisa.append('<ul>');
                                resultados.forEach(function (usuario) {
                                    resultadosPesquisa.append('<li><a href="{{ route("perfil.outro", ["username" => ""]) }}/' + usuario.username + '" wire:navigate>' + usuario.nome + ' (' + usuario.username + ')</a></li>');
                                });
                                resultadosPesquisa.append('</ul>');
                            } else {
                                resultadosPesquisa.append('<p>Nenhum resultado encontrado.</p>');
                            }
                        },
                        error: function (error) {
                            console.error('Erro na chamada AJAX: ', error);
                        }
                    });
                } else {
                    pesquisarBtn.prop('disabled', true); // Desativa o botão
                    // Se a consulta estiver vazia, limpe os resultados
                    resultadosPesquisa.html('');
                }
            });
        });
    </script>
</div>