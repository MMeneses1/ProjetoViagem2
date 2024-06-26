    @extends('layouts.template-inside')
    
    @section('titulo', 'Meu Perfil')
    @section('css', '/css/perfil.css')
    @section('conteudo')

        <!--<a href="{{ route('insta.perfiledit') }}" class="btn btn-primary">Editar Perfil</a>-->
        <div @if($noPosts) style="height: 100vh" @endif>
            <div class = "profileinfo">
                @if(Auth::user()->foto_perfil)
                    <div class="profilepicture">
                        <img src="{{ asset(Auth::user()->foto_perfil) }}" alt="Foto de Perfil" class="profileimage">
                    </div>
                @endif

                <div class="userdetails">
                    <p class = "info">{{ Auth::user()->nome }} • {{Auth::user()->username}}</p>

                    @if(Auth::user()->pais)
                        <p class = "info">{{ Auth::user()->pais }}</p>
                    @endif

                    @if(Auth::user()->biografia)
                        <p class = "info">{{ Auth::user()->biografia }}</p>
                    @endif

                    @if(empty(Auth::user()->biografia) || (Auth::user()->pais))
                        <p class = "seminfo">Complete o seu perfil</p>
                    @endif

                    <span>{{ $postsCount }} publicações •</span>
                    <span class = "quantidade" id="mostrarSeguidores">{{ $followersCount }} seguidores •</span>
                    <span class = "quantidade" id="mostrarSeguindo">{{ $followingCount }} seguindo</span>
                </div>
            </div>

            <livewire:publicacoes />

            <h5>Suas publicações</h5>
            @include('insta.perfilpost')       
        </div>

        <script>
            $(document).ready(function() {
                // Função para criar e exibir o modal com base nos dados
                function exibirModal(title, userList) {
                    var modalContent = `<div class="modal fade" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5">${title}</h1>
                                                        <button type="button" class="btn-close fecharModal" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul>`;

                    userList.forEach(function(user) {
                        modalContent +=
                            `<li class = "listamodal"><a href="{{ route("perfil.outro", ["username" => ""]) }}/${user.username}" wire:navigate>${user.username}</a></li>`;
                    });

                    modalContent += `</ul></div></div></div>`;

                    $('body').append(modalContent);

                    // Adicione um evento de clique ao botão de fechar o modal
                    $('.fecharModal').on('click', function () {
                        $('.modal').remove(); // Remova o modal ao fechar
                    });

                    $('.modal').modal('show');
                }

                // Evento de clique no botão Seguidores
                $('#mostrarSeguidores').on('click', function() {
                    // Faça uma requisição AJAX para obter a lista de seguidores
                    $.ajax({
                        type: 'GET',
                        url: '{{ route("get.followers") }}', // Substitua pelo nome correto da sua rota
                        success: function(data) {
                            // Exiba os dados em um modal
                            exibirModal('Seguidores', data.followers);
                        },
                        error: function(error) {
                            console.error('Erro ao obter a lista de seguidores:', error);
                        }
                    });
                });

                // Evento de clique no botão Seguindo
                $('#mostrarSeguindo').on('click', function() {
                    // Faça uma requisição AJAX para obter a lista de usuários que você está seguindo
                    $.ajax({
                        type: 'GET',
                        url: '{{ route("get.following") }}', // Substitua pelo nome correto da sua rota
                        success: function(data) {
                            // Exiba os dados em um modal
                            exibirModal('Seguindo', data.following);
                        },
                        error: function(error) {
                            console.error('Erro ao obter a lista de seguindo:', error);
                        }
                    });
                });
            });
        </script>
    @endsection

