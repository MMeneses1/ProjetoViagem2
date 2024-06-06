
    @extends('layouts.template-inside')
    @section('titulo', 'Atualizar Perfil')
    @section('css', '/css/perfiledit.css')
    @section('conteudo')

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('perfil.update') }}" method="post" enctype="multipart/form-data" class = "formularioeditar">
                <h4>Atualize suas informações:</h4>
                @csrf
                <div class="form-group">
                    <label for="username">Usuário:</label>
                    <input class="form-control" type="text" id="username" name="username" value="{{ old('username', Auth::user()->username) }}" required>
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone:</label>
                    <input class="form-control" type="text" id="telefone" name="telefone" value="{{ old('telefone', Auth::user()->telefone) }}">
                </div>

                <div class="form-group">
                    <label for="foto_perfil">Foto de Perfil:</label>
                    <input class="form-control" type="file" id="foto_perfil" name="foto_perfil">
                </div>

                <div class="form-group">
                    <label for="biografia">Biografia:</label>
                    <textarea class="form-control" rows = "2" id="biografia" name="biografia">{{ old('biografia', Auth::user()->biografia) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="idioma">Idioma:</label>
                    <input class="form-control" type="text" id="idioma" name="idioma" value="{{ old('idioma', Auth::user()->idioma) }}">
                </div>

                <button type="submit" class="btn btn-success">Atualizar Perfil</button>
            </form>
    @endsection