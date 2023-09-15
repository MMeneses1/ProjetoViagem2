<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    
</head>
<body>
    <div class="container">
        <h1>Registro</h1>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="post">
            {{ csrf_field() }}
            <label for="email">E-mail de usuário:</label>
            <input type="text" id="email" name="email" value="{{ old('email') }}" required>
            
            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required>
            
            <label for="username">Nome de Usuário:</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required>
            
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="password_confirmation">Confirme a senha:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            
            <button type="submit">Registrar</button>
        </form>
        
        <a href="{{ route('login') }}">Já tem uma conta? Conecte-se</a>
    </div>
</body>
</html>
