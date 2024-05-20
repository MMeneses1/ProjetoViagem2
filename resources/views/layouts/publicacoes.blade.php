<div>    
    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data" class="formulariopost">
        @csrf
        <div class="form-group">
            <textarea id="content" name="content" rows = '5' max = "250" class="form-control" placeholder="Digite o texto da sua publicação" required></textarea>
            <input class="form-control" type="file" id="image" name="image">
        </div>

        <button type="submit" class="btn btn-success criarpost">Criar Publicação</button>

    </form>
</div>