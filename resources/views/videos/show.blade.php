@extends('layouts.app')

@section('content')
    <div class="container-fluid p-4">
        <div class="row">
            <!-- Section de la vidéo principale -->
            <div class="col-lg-8 col-md-12">
                <div class="video-player mb-4">
                    <!-- Vidéo avec fond noir -->
                    <video controls width="100%" style="background-color: #000;">
                        <source src="{{ Storage::url($video->video_path) }}" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture de cette vidéo.
                    </video>

                    <!-- Détails de la vidéo avec fond blanc -->
                    <div class="video-details mt-3">
                        <h3 class="video-title">{{ $video->title }}</h3>
                        <p class="text-muted">Date de publication : {{ $video->published_at }}</p>
                        <p class="video-description">{{ $video->description }}</p>
                    </div>
                </div>

                <!-- Section des commentaires -->
                <div class="comments-section mb-4">
                    <h5>Commentaires</h5>

                    <!-- Formulaire d'ajout de commentaire -->
                    @auth
                        <form action="{{ route('comments.store', $video->id) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="form-group">
                                <textarea name="content" class="form-control" rows="3" placeholder="Écrivez un commentaire..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success mt-2">Ajouter un commentaire</button>
                        </form>
                    @endauth

                    <!-- Affichage des commentaires -->
                    @foreach ($comments as $comment)
                        <div class="comment mb-3" id="comment-{{ $comment->id }}">
                            <div class="comment-header">
                                <strong>{{ $comment->user->name }}</strong>
                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="comment-content">{{ $comment->content }}</p>

                            <!-- Bouton Répondre -->
                            @auth
                                <button class="btn btn-link btn-sm p-0" onclick="toggleReplyForm({{ $comment->id }})">Répondre</button>
                            @endauth

                            <!-- Formulaire de réponse (caché par défaut) -->
                            <div id="reply-form-{{ $comment->id }}" class="reply-form mt-2" style="display:none;">
                                <form action="{{ route('comments.store', $video->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="content" class="form-control" rows="2" placeholder="Votre réponse..." required></textarea>
                                    </div>
                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                    <button type="submit" class="btn btn-primary btn-sm mt-2">Répondre</button>
                                </form>
                            </div>

                            <!-- Affichage des réponses -->
                            @if($comment->replies->count() > 0)
                                <button class="btn btn-link btn-sm p-0 mt-2" onclick="toggleReplies({{ $comment->id }})" id="toggle-replies-btn-{{ $comment->id }}">
                                    Afficher les réponses ({{ $comment->replies->count() }})
                                </button>
                                <div id="replies-{{ $comment->id }}" class="replies mt-2" style="display:none;">
                                    @foreach ($comment->replies as $reply)
                                        <div class="reply ms-4 mt-3">
                                            <div class="reply-header">
                                                <strong>{{ $reply->user->name }}</strong>
                                                <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="reply-content">{{ $reply->content }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Section des autres vidéos dans la playlist -->
            <div class="col-lg-4 col-md-12">
                <h5 class="mb-3">Autres vidéos dans la playlist "{{ $video->category->name }}"</h5>
                <div class="related-videos">
                    @foreach ($video->category->videos as $relatedVideo)
                        @if ($relatedVideo->id != $video->id)
                            <div class="related-video mb-3">
                                <a href="{{ route('videos.show', $relatedVideo->id) }}" class="text-decoration-none">
                                    <div class="d-flex">
                                        <img src="{{ Storage::url($relatedVideo->thumbnail) }}"
                                             alt="{{ $relatedVideo->title }}"
                                             class="related-video-thumbnail">
                                        <div class="related-video-details ms-3"><br>
                                            <h6 class="related-video-title">{{ Str::limit($relatedVideo->title, 50) }}</h6>
                                            <small class="text-muted">{{ $relatedVideo->published_at }}</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
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
                button.innerText = 'Masquer les réponses';
            } else {
                replies.style.display = 'none';
                button.innerText = 'Afficher les réponses';
            }
        }
    </script>

    <style>
        /* Styles pour la vidéo principale */
        .video-player {
            background-color: #fff; /* Fond blanc pour le conteneur */
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Ombre légère */
        }

        .video-details {
            padding: 16px;
            background-color: #fff; /* Fond blanc */
            border-radius: 0 0 8px 8px; /* Arrondir les coins inférieurs */
        }

        .video-title {
            font-size: 1.5rem;
            margin-bottom: 8px;
        }

        .video-description {
            font-size: 0.9rem;
            color: #666;
        }

        /* Styles pour les commentaires */
        .comments-section {
            padding: 16px;
        }

        .comment {
            border-bottom: 1px solid #eee;
            padding-bottom: 12px;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .comment-content {
            font-size: 0.9rem;
            margin: 8px 0;
        }

        .reply {
            border-left: 2px solid #ddd;
            padding-left: 12px;
        }

        .reply-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .reply-content {
            font-size: 0.85rem;
            color: #555;
        }

        /* Styles pour les vidéos associées */
        .related-videos {
            padding: 16px;
        }

        .related-video-thumbnail {
            width: 180px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .related-video-details {
            flex: 1;
            margin-left: 16px; /* Ajustez cette valeur selon vos besoins */
        }

        .related-video-title {
            font-size: 0.9rem;
            margin-bottom: 4px;
        }
    </style>
@endsection
