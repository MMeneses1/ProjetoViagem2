<div id="postsContainer" @if($noPosts) style="height: 80vh" @endif>
@include('layouts.posts')
</div>

<script>
$(document).ready(function(){
    // Função para aplicar eventos aos botões de mostrar comentários
    function applyCommentEvents() {
        const showCommentsButtons = document.querySelectorAll('.mostrar-comentarios-btn');
        showCommentsButtons.forEach(function(showCommentsButton) {
            const commentsSection = showCommentsButton.nextElementSibling;
            const commentForm = commentsSection.nextElementSibling;

            showCommentsButton.addEventListener('click', function () {
                if (commentsSection.style.display === 'none' || commentsSection.style.display === '') {
                    commentsSection.style.display = 'block';
                    commentForm.style.display = 'block';
                } else {
                    commentsSection.style.display = 'none';
                    commentForm.style.display = 'none';
                }
            });
        });
    }

    // Função para carregar mais posts via AJAX
    var carregandoPosts = false;
    var currentPage = {{ $postsPage }};
    var allPostsLoaded = false;

    var checkScroll = function() {
        if (!carregandoPosts && !allPostsLoaded && ($("#postsContainer").scrollTop() + $("#postsContainer").height() >= $("#postsContainer")[0].scrollHeight- 20)) {
            carregandoPosts = true;

            $.ajax({
                url: "{{ route('perfil') }}",
                type: "GET",
                data: {
                    loadedPosts: {{ $loadedPosts }},
                    page: currentPage + 1,
                },
                success: function(response) {
                    var posts = $(response).find('.post'); // Modifique o seletor conforme necessário para corresponder aos seus posts
                    if (posts.length) {
                        $("#postsContainer").append(posts);
                        currentPage++;
                        applyCommentEvents(); // Aplicar eventos aos novos posts
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

    // Aplicar eventos aos botões de mostrar comentários nos posts já existentes
    applyCommentEvents();
});
</script>