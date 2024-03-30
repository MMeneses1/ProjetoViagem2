

<div id="postsContainer" @if($noPosts) style="height: 80vh" @endif>

@include('layouts.posts')
</div>

<script>

$(document).ready(function(){
    var carregandoPosts = false;
    var currentPage = {{ $postsPage }};
    var allPostsLoaded = false;

    $("#postsContainer").scroll(function(){
        if (!carregandoPosts && !allPostsLoaded && ($(this).scrollTop() + $(this).height() >= $(this)[0].scrollHeight)) {
            carregandoPosts = true;

            $.ajax({
                url: "{{ route('feed') }}",
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
    });
});
</script>