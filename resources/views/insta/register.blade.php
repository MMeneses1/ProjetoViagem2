<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="/css/styles.css"> 
</head>
<body>
    <div class="container">
        <h1>Registro</h1>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="post" enctype="multipart/form-data"> <!-- Adicione 'enctype' para lidar com o upload de arquivos -->
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
            
            <!-- Novos campos -->
            <label for="sexo">Sexo:</label>
            <input type="text" id="sexo" name="sexo" value="{{ old('sexo') }}">
            
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="{{ old('telefone') }}">
            
            <label for="pais">País:</label>
            <input type="text" id="pais" name="pais" value="{{ old('pais') }}">
            
            
            <label for="foto_perfil">Foto de Perfil:</label>
            <input type="file" id="foto_perfil" name="foto_perfil">
            
            <button type="submit">Registrar</button>
        </form>
        
        <a href="{{ route('login') }}">Já tem uma conta? Conecte-se</a>
    </div>
</body>
</html>
