@section('content')
    <div class="container">
        <h1>Resultados da Pesquisa para "{{ $query }}"</h1>

        @if($resultados->isEmpty())
            <p>Nenhum usuário encontrado.</p>
        @else
            <p>Encontrado(s) {{ $resultados->count() }} usuário(s) com o nome "{{ $query }}".</p>
            <ul>
                @foreach($resultados as $usuario)
                    <li>
                        <a href="{{ route('perfil.outro', ['username' => $usuario->username]) }}">
                            {{ $usuario->nome }} ({{ $usuario->username }})
                        </a>
                    </li>
                    {{-- Adicione esta linha para depuração --}}
                    {{ dd($usuario) }}
                @endforeach
            </ul>
        @endif
    </div>
@endsection