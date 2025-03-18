@extends('layouts.app')

@section('content')
    <div class="container-fluid p-4">
        <h3 class="mb-4">Toutes les vidéos</h3>

        <!-- Conteneur des vidéos -->
        <div class="video-grid">
            @foreach ($videos as $video)
                <div class="video-card">
                    <!-- Miniature de la vidéo -->
                    <a href="{{ route('videos.show', $video->id) }}">
                        <img src="{{ Storage::url($video->thumbnail) }}"
                             class="video-thumbnail"
                             alt="{{ $video->title }}">
                    </a>
                    <!-- Détails de la vidéo -->
                    <div class="video-details">
                        <h6 class="video-title">
                            <a href="{{ route('videos.show', $video->id) }}" class="text-dark text-decoration-none">
                                {{ Str::limit($video->title, 50) }}
                            </a>
                        </h6>
                        <p class="video-description text-muted">
                            {{ Str::limit($video->description, 80) }}
                        </p>
                        <small class="text-muted">{{ $video->published_at }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<style>
    .video-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 16px;
        padding: 16px;
    }

    .video-card {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .video-card:hover {
        transform: translateY(-5px);
    }

    .video-thumbnail {
        width: 100%;
        height: 150px;
        object-fit: cover;
        background-color: #f8f9fa;
    }

    .video-details {
        padding: 12px;
    }

    .video-title {
        font-size: 1rem;
        margin-bottom: 8px;
    }

    .video-description {
        font-size: 0.875rem;
        margin-bottom: 8px;
    }

    .text-muted {
        font-size: 0.75rem;
    }
</style>
