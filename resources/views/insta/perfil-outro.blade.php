@extends('layouts.template-inside')
@section('titulo', $otherUser->username)
@section('css', '/css/perfil.css')
@section('conteudo')

<div @if($noPosts) style="height: 100vh" @endif>
    <div class="profileinfo">
        @if($otherUser->foto_perfil)
            <div class="profilepicture">
                <img src="{{ asset($otherUser->foto_perfil) }}" alt="Foto de Perfil" class="profileimage">
            </div>
        @endif

        <div class="userdetails">
            <p class="info">{{ $otherUser->name }} • {{ $otherUser->username }}</p>

            @if($otherUser->pais)
                <p class="info">{{ $otherUser->pais }}</p>
            @endif

            @if($otherUser->biografia)
                <p class="info">{{ $otherUser->biografia }}</p>
            @endif

            @if(auth()->user()->isFollowing($otherUser))
                <form action="{{ route('perfil.deixar-de-seguir', ['username' => $otherUser->username]) }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-success" type="submit">Deixar de Seguir</button>
                </form>
            @elseif(auth()->user()->id !== $otherUser->id)
                <form action="{{ route('perfil.seguir', ['username' => $otherUser->username]) }}" method="POST">
                    @csrf
                    <button class="btn btn-success" type="submit">Seguir</button>
                </form>
            @endif

            <span class="quantidade" id="mostrarSeguidores">{{ $followersCount }} seguidores</span>
            <span class="quantidade" id="mostrarSeguindo">{{ $followingCount }} seguindo</span>


        </div>


    </div>

    @include('insta.perfil-outropost')   

</div>

@endsection

@section('scripts')
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
                    `<li class="listamodal"><a href="{{ route("perfil.outro", ["username" => ""]) }}/${user.username}">${user.username}</a></li>`;
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
                url: '{{ route("get.followers", ["username" => $otherUser->username]) }}',
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
            // Faça uma requisição AJAX para obter a lista de usuários que este usuário está seguindo
            $.ajax({
                type: 'GET',
                url: '{{ route("get.following", ["username" => $otherUser->username]) }}',
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
