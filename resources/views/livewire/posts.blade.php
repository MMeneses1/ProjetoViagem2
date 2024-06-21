<div>
    @if(!$noPosts)
    <ul role="list" class="postslista">
        @foreach($posts->sortByDesc('created_at') as $index => $post)
            <li wire:key="{{ $post->id }}" class="postitem">
                <div class="conteudopost">
                    <div class="card post">
                        <div class="card-header header">
                            <span class="userpost">
                                @if(Auth::user()->username == $post->user->username)
                                    @if(Auth::user()->foto_perfil)
                                        <img src="{{ asset(Auth::user()->foto_perfil) }}" alt="Foto de Perfil" class="perfilfeed">
                                    @endif
                                    <a class = "linkperfil" href="{{ route('perfil') }}" wire:navigate>{{ $post->user->username }}</a> • {{ $post->created_at->diffForHumans() }} • Diário: {{ $post->diario->content }}
                                @else
                                    @if($post->user->foto_perfil)
                                        <img src="{{ asset($post->user->foto_perfil) }}" alt="Foto de Perfil" class="perfilfeed">
                                    @endif
                                    <a class = "linkperfil" href="{{ route('perfil.outro', ['username' => $post->user->username]) }}" wire:navigate>{{ $post->user->username }}</a> • {{ $post->created_at->diffForHumans() }} • Diário: {{ $post->diario->content }}
                                @endif
                            </span>
                            <form wire:submit="like({{ $post }})">
                                <a>{{$post->likes}}</a>
                                <button type="submit" class="btn">
                                    <img class="curtirpost" src="{{ asset('images/likevazio.png') }}"/>
                                </button>
                            </form>
                            <!-- Verifique se a postagem pertence ao usuário autenticado -->
                            @if(Auth::user()->id === $post->user->id)
                                <!-- Botão de exclusão do post -->
                                <form wire:submit="destroy({{ $post }})">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn">
                                        <img class="excluirpost" src="{{ asset('images/lixeira.png') }}"/>
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="row maxtam">
                            @foreach($post->paginas as $index => $pagina)
                            <div class="card-body col-md-4 d-flex justify-content-center">
                                <div class="quadradopost align-content-center flex-wrap">  
                                    @if(!empty($pagina->content))
                                    <p class="textopost">{{ $pagina->content }}</p>
                                    @endif
                                    @if($pagina->image)
                                    <div class="imagempost">
                                        <img src="{{ asset($pagina->image) }}" alt="Imagem da postagem">
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <livewire:comments :$post :postId="$post->id" :key="rand()"/>

                    </div>
                </div>
            </li>
            <hr/>
        @endforeach
        <div
            x-data="{
                observe () {
                    let observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                @this.call('carregarMais')
                            }
                        })
                    }, {
                        root: null
                    })

                    observer.observe(this.$el)
                }
            }"
            x-init="observe"
        ></div>
    </ul>
       
    @else
        <p>Nenhuma publicação foi encontrada.</p>
    @endif
</div>
