<div>    
    <form wire:submit="store" class="formulariopost">
        @csrf
        <div class="form-group">
            <textarea wire:model="content" id="content" name="content" rows = '5' max = "250" class="form-control" placeholder="Digite o texto da sua publicação"></textarea>
            <input  wire:model="image" class="form-control" type="file" id="image" name="image">
        </div>

        <button type="submit" class="btn btn-success criarpost">Criar Publicação</button>

    </form>
</div>