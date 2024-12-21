@extends('layouts.app')

@section('content')
<div class="container" style="width: 100%; margin: 0; padding: 0;">
    <div class="row">
        <!-- Section de la vidéo principale -->
        <div class="col-md-8">
            <div class="card mb-4">
                <video controls width="100%">
                    <source src="{{ Storage::url($video->video_path) }}" type="video/mp4">
                    Votre navigateur ne supporte pas la lecture de cette vidéo.
                </video>
                <div class="card-body">
                    <h3 class="card-title">{{ $video->title }}</h3>
                    <p class="text-muted">{{ $video->published_at }}</p>
                    <p>{{ $video->description }}</p>
                </div>
            </div>
        </div>


        
<!-- Section des autres vidéos dans la playlist -->
<div class="col-md-4">
    <h5>Autres vidéos dans la playlist "{{ $video->category->name }}"</h5>
    <div class="row">
        @foreach ($video->category->videos as $relatedVideo)
            @if ($relatedVideo->id != $video->id)
                <div class="col-6 mb-4">
                    <div class="card">
                        <!-- La miniature mène à la page de contenu de la vidéo -->
                        <a href="{{ route('videos.show', $relatedVideo->id) }}">
                            <img src="{{ Storage::url($relatedVideo->thumbnail) }}" 
                                 alt="{{ $relatedVideo->title }}" 
                                 class="card-img-top" 
                                 >
                        </a>
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="{{ route('videos.show', $relatedVideo->id) }}" class="text-dark text-decoration-none">
                                    {{ Str::limit($relatedVideo->title, 40) }}
                                </a>
                            </h6>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>


<!-- Section des commentaires -->
<div class="col-md-8">
<!-- Section des commentaires -->
<div class="card mb-4">
    <div class="card-body">
        <h5>Commentaires</h5>

        @auth
        <form action="{{ route('comments.store', $video->id) }}" method="POST" class="col-md-10">
            @csrf
            <div class="form-group">
                <textarea name="content" class="form-control" rows="3" placeholder="Écrivez un commentaire..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Ajouter un commentaire</button>
        </form>
        @endauth

        <hr>

        <!-- Affichage des commentaires principaux -->
        @foreach ($comments as $comment)
            <div class="mb-3" id="comment-{{ $comment->id }}">
                <strong>{{ $comment->user->name }}</strong>
                <p>{{ $comment->content }}</p>
                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>

                <!-- Bouton Répondre -->
                @auth
                    <button class="btn btn-link mt-2" onclick="toggleReplyForm({{ $comment->id }})">Répondre</button>
                @endauth

                <!-- Formulaire de réponse caché -->
                <div id="reply-form-{{ $comment->id }}" class="mt-3" style="display:none;">
                    <form action="{{ route('comments.store', $video->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="content" class="form-control" rows="2" placeholder="Votre réponse..." required></textarea>
                        </div>
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <button type="submit" class="btn btn-primary mt-2">Répondre</button>
                    </form>
                </div>

                <!-- Bouton pour afficher/masquer les réponses -->
                @if($comment->replies->count() > 0)
                    <button class="btn btn-link mt-2" onclick="toggleReplies({{ $comment->id }})" id="toggle-replies-btn-{{ $comment->id }}">
                        Afficher les réponses
                    </button>
                @endif

                <!-- Affichage des réponses (cachées par défaut) -->
                <div id="replies-{{ $comment->id }}" style="display:none;">
                    @foreach ($comment->replies as $reply)
                        <div class="mt-3 ms-4">
                            <strong>{{ $reply->user->name }}</strong>
                            <p>{{ $reply->content }}</p>
                            <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
</div>

<script>
    // Fonction pour afficher/masquer le formulaire de réponse
    function toggleReplyForm(commentId) {
        var replyForm = document.getElementById('reply-form-' + commentId);
        if (replyForm.style.display === 'none' || replyForm.style.display === '') {
            replyForm.style.display = 'block';
        } else {
            replyForm.style.display = 'none';
        }
    }

    // Fonction pour afficher/masquer les réponses
    function toggleReplies(commentId) {
        var replies = document.getElementById('replies-' + commentId);
        var button = document.getElementById('toggle-replies-btn-' + commentId);

        if (replies.style.display === 'none' || replies.style.display === '') {
            replies.style.display = 'block';
            button.innerText = 'Masquer les réponses'; // Modifier le texte du bouton
        } else {
            replies.style.display = 'none';
            button.innerText = 'Afficher les réponses'; // Modifier le texte du bouton
        }
    }
</script>




@endsection
