
@section('content')
<link rel="stylesheet" href="/css/styles.css">
<<div class="container">
    <h1>Perfil do Usuário</h1>
    @if (session('login_success'))
        <div class="alert alert-success">
            Login bem-sucedido!
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <p>Nome: {{ $usuario->nome }}</p>
    <p>E-mail: {{ $usuario->email }}</p>
    <p>Username: {{ $usuario->username }}</p>
</div>
@endsection
