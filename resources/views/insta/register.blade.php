@extends('layouts.header')
@section('titulo', 'Cadastre-se')
@section('css', '/css/register.css')
@section('conteudo')

        <div class = "row landingpage">
            <div class = "col-md-12">
                <h1 class = "titulolanding">Te levando para os melhores lugares</h1>
                <p class = "paragrafolanding">Comece a sua jornada</p>
                <a href="#formulario">
                    <img class="iconelanding" src="{{ asset('images/seta.png') }}">
                </a>
            </div>
        </div>

        <div class = "row">
            <div class = "col-md-6"></div>
            <div class = "col-md-5">
            <form action="{{ route('register') }}" id = "formulario" name = "formulario" method="post" enctype="multipart/form-data" class="formregister needs-validation" novalidate> <!-- Adicione 'enctype' para lidar com o upload de arquivos -->
                {{ csrf_field() }}
                    
                    <label class="form-label" for="email">E-mail:</label>
                    <input class="form-control @error('email') is-invalid @enderror" type="text" id="email" name="email" value="{{ old('email') }}" placeholder = "exemplo@email.com" required>
                    @error('email')
                        <div class="invalid-tooltip position-relative">
                            {{ $message }}
                        </div>
                    @enderror
                    
                    <label class="form-label" for="nome">Nome:</label>
                    <input class="form-control @error('nome') is-invalid @enderror" type="text" id="nome" name="nome" value="{{ old('nome') }}" placeholder = "Digite o seu nome completo" required>
                    @error('nome')
                        <div class="invalid-tooltip position-relative">
                            {{ $message }}
                        </div>
                    @enderror
                    
                    <label class="form-label" for="username">Usuário:</label>
                    <input class="form-control @error('senha') is-invalid @enderror" type="text" id="username" name="username" value="{{ old('username') }}" placeholder = "@usuario" required>
                    @error('usuario')
                        <div class="invalid-tooltip position-relative">
                            {{ $message }}
                        </div>
                    @enderror
                    
                    <label class="form-label" for="password">Senha:</label>
                    <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder = "Digite a sua senha" required>
                    @error('password')
                        <div class="invalid-tooltip position-relative">
                            {{ $message }}
                        </div>
                    @enderror
                    
                    <label class="form-label" for="password_confirmation">Confirme a sua senha:</label>
                    <input class="form-control @error('password') is-invalid @enderror" type="password" id="password_confirmation" name="password_confirmation" placeholder = "Confirme a sua senha" required>
                    @error('password.confirmed')
                        <div class="invalid-tooltip position-relative">
                            {{ $message }}
                        </div>
                    @enderror
                    
                    <!-- Novos campos
                    <label class="form-label" for="sexo">Sexo:</label>
                    <input class="form-control" type="text" id="sexo" name="sexo" value="{{ old('sexo') }}">-->
                    
                    <!-- <label class="form-label" for="telefone">Telefone:</label>
                    <input class="form-control" type="text" id="telefone" name="telefone" value="{{ old('telefone') }}" placeholder = "(99) 99999-9999">-->
                    
                    <!-- <label class="form-label" for="pais">País:</label>
                    <input class="form-control" type="text" id="pais" name="pais" value="{{ old('pais') }}">
                    
                    <label class="form-label" for="foto_perfil">Foto de Perfil:</label>
                    <input class="form-control" type="file" id="foto_perfil" name="foto_perfil">-->
                    
                    <p>
                        Ao se cadastrar você confirma que concorda com os Termos de Condição do site.
                    </p>

                    <button class="btn" type="submit">Cadastre-se</button>

                    <p class = "loginlanding">Já tem uma conta? <a href="{{ route('login') }}">Conecte-se</a></p>
                </form>
            </div>
            <div class="col-md-1"></div>
        </div>
@endsection