<div>
    <div id="postsContainer" @if($noPosts) style="height: 80vh" @endif>
    <livewire:posts :userId="auth()->user()->id"/>
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

        // Aplicar eventos aos botões de mostrar/comentar nos posts já existentes
        applyEventsToNewComments(document);

    });

    </script>
</div>