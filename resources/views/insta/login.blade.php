    @extends('layouts.header')
    @section('titulo', 'Login')
    @section('css', '/css/login.css')
    @section('conteudo')

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-5 login">
            <h1 class="titulologin">Bem vindo de volta!</h1>
            <p class="paragrafologin">Entre com os seus dados para compartilhar mais uma viagem.</p>
        </div>

        <div class="col-md-5 formlogin">
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            <form action="{{ route('login') }}" method="POST" class="formlogin">
                <h2>Acesse a sua conta<h2>
                        @csrf <!-- Adicione o token CSRF -->
                        <label class="form-label" for="email_or_username">E-mail ou usuário:</label>
    <input type="text" class="form-control" placeholder="exemplo@email.com ou nome de usuário" name="email_or_username">


                <label class="form-label" for="password">Senha:</label>
                <input type="password" class="form-control" placeholder="Digite a sua senha" name="password">

                <!-- Link "Esqueci minha senha" -->
                <a href="{{ route('password.request') }}" wire:navigate>Esqueci a minha senha</a>

                <button class="btn" type="submit">Entrar</button>
            </form>

            <p class="registerlogin">Não tem uma conta? <a href="/signup" wire:navigate>Clique aqui para se cadastrar!</a></p>
        </div>
        <div class="col-md-1"></div>
    </div>

    @endsection