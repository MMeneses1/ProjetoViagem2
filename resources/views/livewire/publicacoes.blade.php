<div class="row postagemTudo">
    <div class="">    
        <form wire:submit="store" class="formulariopost">
            @csrf
            <div class="row p2">
                <div class="col px-md-0 form-group">
                    <div class="form-check-inline ">
                        <label>Quantidade de posts:</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1" wire:model="quantidade">
                        <label class="form-check-label" for="inlineRadio1">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2" wire:model="quantidade">
                        <label class="form-check-label" for="inlineRadio2">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="3" wire:model="quantidade">
                        <label class="form-check-label" for="inlineRadio3">3</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col px-md-0 form-group">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipoRadio1" id="tipoRadio1img" value="imagem" wire:model="tipo1">
                        <label class="form-check-label" for="tipoRadio1">Imagem</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipoRadio1" id="tipoRadio1txt" value="texto" wire:model="tipo1">
                        <label class="form-check-label" for="tipoRadio2">Texto</label>
                    </div>
                    <div>
                        <textarea x-show="$wire.tipo1 == 'texto'" wire:model="content1" id="content1" name="content1" rows = '5' max = "250" class="form-control" placeholder="Digite o texto da sua publicação"></textarea>
                        <input x-show="$wire.tipo1 == 'imagem'" wire:model="image1" class="form-control form-image" type="file" id="image1" name="image1">
                    </div>
                </div>
                <div  x-show="$wire.quantidade >= 2" class="col px-md-0 form-group">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipoRadio2" id="tipoRadio2img" value="imagem" wire:model="tipo2">
                        <label class="form-check-label" for="inlineRadio1">Imagem</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipoRadio2" id="tipoRadio2txt" value="texto" wire:model="tipo2">
                        <label class="form-check-label" for="inlineRadio2">Texto</label>
                    </div>
                    <div>
                        <textarea x-show="$wire.tipo2 == 'texto'" wire:model="content2" id="content2" name="content2" rows = '5' max = "250" class="form-control" placeholder="Digite o texto da sua publicação"></textarea>
                        <input x-show="$wire.tipo2 == 'imagem'"  wire:model="image2" class="form-control form-image" type="file" id="image2" name="image2">
                    </div>
                </div>
                <div  x-show="$wire.quantidade >= 3" class="col px-md-0 form-group">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipoRadio3" id="tipoRadio3img" value="imagem" wire:model="tipo3">
                        <label class="form-check-label" for="inlineRadio1">Imagem</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipoRadio3" id="tipoRadio3txt" value="texto" wire:model="tipo3">
                        <label class="form-check-label" for="inlineRadio2">Texto</label>
                    </div>
                    <div>
                        <textarea x-show="$wire.tipo3 == 'texto'" wire:model="content3" id="content3" name="content3" rows = '5' max = "250" class="form-control" placeholder="Digite o texto da sua publicação"></textarea>
                        <input x-show="$wire.tipo3 == 'imagem'" wire:model="image3" class="form-control form-image" type="file" id="image3" name="image3">
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-md-2" for="album">Nome do Diário:</label>
                <textarea wire:model="album" id="album" name="album" rows = '1' max = "50" class="col-md-8 form-control" placeholder="Digite o nome de um album existente ou um novo"></textarea>
            </div>
            <button type="submit" class="btn btn-success criarpost">Criar Publicação</button>
        </form>
    </div>
    
    <style>
        input.form-check-input:checked {
            background-color: #5e17eb;
        }
        input.form-image {
            min-height: 134px;
            align: center;
        }
        .no-padding {
            padding: 0 !important;
        }
    </style>
</div>