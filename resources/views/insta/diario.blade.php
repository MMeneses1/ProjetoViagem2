
    @extends('layouts.template-inside')
    @section('titulo', 'Página Inicial')
    @section('css', '/css/perfil.css')
    @section('conteudo')
    <livewire:publicacoes />




    <div class="container">
        @foreach($diarioPosts as $diario)
        <div class="diario-card card mb-4">
            <div class="card-body">
                <h5 class="diario-title card-title">{{ $diario->content }}</h5>
                <!-- Exibir a localização -->
                <p>Localização: {{ $diario->address }}</p>
                <!-- Adicione qualquer outra informação do diário que deseja exibir -->
                <div class="posts-wrapper row">
                    @foreach($diario->posts as $post)
                    <div class="post-card col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <p class="post-content card-text">{{ $post->content }}</p>
                                <!-- Adicione a tag de imagem para exibir a imagem da postagem, se presente -->
                                @if($post->image)
                                    <img src="{{ asset($post->image) }}" class="img-fluid" alt="Imagem da postagem">
                                @endif
                                <!-- Adicione qualquer outra informação do post que deseja exibir -->
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Diário</title>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <style>
            #map {
                height: 400px;
                width: 100%;
            }
        </style>
    </head>
    <body>
    <div id="map" style="display: none;"></div>


        <div>
        <form action="{{ route('diario.store') }}" method="POST" enctype="multipart/form-data" class="formulariopost">
        @csrf
        <div class="form-group">
            <textarea id="content" name="content" rows='5' class="form-control" placeholder="Digite o texto da sua publicação" required>{{ old('content') }}</textarea>
            @error('content')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            
            <label for="address" class="mt-3">Endereço (opcional):</label>
            <input id="pac-input" type="text" name="address" class="form-control" placeholder="Digite o endereço">
            
            @for ($i = 0; $i < 3; $i++)
                <label for="post_content_{{ $i }}" class="post-number">Postagem {{ $i + 1 }}</label>
                <textarea id="post_content_{{ $i }}" name="post_content_{{ $i }}" rows='5' class="form-control mt-2" placeholder="Digite o texto da postagem {{ $i + 1 }}">{{ old('post_content_' . $i) }}</textarea>
                <!-- Adicione campos de upload de imagem para cada postagem -->
                <input class="form-control mt-2" type="file" id="post_image_{{ $i }}" name="post_image_{{ $i }}">
                <!-- Verificação de erros para a imagem da postagem, se necessário -->
                @error('post_image_' . $i)
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <!-- Verificação de erros para o conteúdo da postagem, se necessário -->
                @error('post_content_' . $i)
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            @endfor
        </div>
        <button type="submit" class="btn btn-success criarpost">Criar Publicação</button>
    </form>
        </div>

        <script>
            function initMap() {
                const map = new google.maps.Map(document.getElementById("map"), {
                    center: { lat: 40.749933, lng: -73.98633 },
                    zoom: 13,
                    mapTypeControl: false,
                });

                const input = document.getElementById("pac-input");
                const autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.bindTo("bounds", map);

                autocomplete.addListener("place_changed", function () {
                    const place = autocomplete.getPlace();
                    if (!place.geometry || !place.geometry.location) {
                        window.alert("No details available for input: '" + place.name + "'");
                        return;
                    }

                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                    
                    document.getElementById("address").value = place.formatted_address;
                });
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBk_ltLlGEsc3XBSEXp9t8x3S_8U0uXIsc&libraries=places&callback=initMap" async defer></script>
    </body>
    </html>




    <style>
    .diario-card {
        display: flex;
        flex-direction: column;
        gap: 20px; /* Espaçamento entre os diários */
    }

    .posts-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Espaçamento entre os posts */
    }

    .post-card {
        width: calc(33.33% - 20px); /* Largura dos posts */
    }

    @media (max-width: 768px) {
        .post-card {
            width: calc(50% - 20px); /* Largura dos posts em telas menores */
        }
    }
    </style>

    @endsection