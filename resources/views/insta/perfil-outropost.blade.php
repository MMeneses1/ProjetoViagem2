<div>
    <div id="postsContainer" @if($noPosts) style="height: 80vh" @endif>
    @include('layouts.posts')
    </div>

    <script>
    $(document).ready(function(){
        // Função para aplicar eventos aos botões de mostrar/comentar
        function applyEventsToNewComments(container) {
            $(container).find('.mostrar-comentarios-btn').each(function() {
                var showCommentsButton = $(this);
                var commentsSection = showCommentsButton.next('.boxcomentarios');
                var commentForm = commentsSection.find('.formulariocomentario');

                showCommentsButton.on('click', function () {
                    if (commentsSection.is(':hidden')) {
                        commentsSection.show();
                        commentForm.show();
                        showCommentsButton.text('Esconder Comentários');
                    } else {
                        commentsSection.hide();
                        commentForm.hide();
                        showCommentsButton.text('Mostrar Comentários');
                    }
                });
            });
        }

        // Função para carregar mais posts via AJAX
        var carregandoPosts = false;
        var currentPage = {{ $postsPage }};
        var allPostsLoaded = false;

        var checkScroll = function() {
        if (!carregandoPosts && !allPostsLoaded && ($("#postsContainer").scrollTop() + $("#postsContainer").height() >= $("#postsContainer")[0].scrollHeight - 40)) {
            carregandoPosts = true;

            $.ajax({
                url: "{{ route('perfil.outro', ['username' => $otherUser->username]) }}",
                type: "GET",
                data: {
                    loadedPosts: {{ $loadedPosts }},
                    page: currentPage + 1,
                },
                success: function(response) {
                    var posts = $(response).find('.post');
                    if (posts.length) {
                        $("#postsContainer").append(posts);
                        currentPage++;
                        applyEventsToNewComments(posts);
                    } else {
                        allPostsLoaded = true;
                    }
                },
                complete: function() {
                    carregandoPosts = false;
                },
                error: function(xhr) {
                    console.log('Erro ao carregar mais posts');
                    carregandoPosts = false;
                }
            });
        }
    };

        $("#postsContainer").scroll(checkScroll);
        $(window).resize(checkScroll);

        // Aplicar eventos aos botões de mostrar/comentar nos posts já existentes
        applyEventsToNewComments(document);

    });

    </script>
</div>