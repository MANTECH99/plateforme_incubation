@extends('layouts.app')

@section('content')
<div class="container" style="width: 100%; margin: 0; padding: 0;">
    <h3 class="mb-4">Toutes les vidéos</h3>
    
    <!-- Conteneur des vidéos -->
    <div class="row g-3">
        @foreach ($videos as $video)
            <div class="col-md-4 col-sm-6">
                <div class="card h-100">
                    <!-- Miniature de la vidéo -->
                    <a href="{{ route('videos.show', $video->id) }}">
                        <img src="{{ Storage::url($video->thumbnail) }}" 
                             class="card-img-top" 
                             alt="{{ $video->title }}" 
                             style="height: 180px; width: 100%; object-fit: contain; background-color: #f8f9fa;">
                    </a>
                    <!-- Détails de la vidéo -->
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title mb-2">
                            <a href="{{ route('videos.show', $video->id) }}" class="text-dark text-decoration-none">
                                {{ Str::limit($video->title, 50) }}
                            </a>
                        </h6>
                        <p class="card-text text-muted mb-2" style="font-size: 0.9rem;">
                            {{ Str::limit($video->description, 80) }}
                        </p>
                        <small class="text-muted mt-auto">{{ $video->published_at }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
