@extends('layouts.app')

@section('content')
<div class="container" style="width: 100%; margin: 0; padding: 0;">
    <h1 class="mb-4">Playlist: {{ $category->name }}</h1>
    <div class="row">
        @foreach ($category->videos as $video)
            <div class="col-md-3">
                <div class="card mb-4">
                    <!-- La miniature mène à la page de contenu de la vidéo -->
                    <a href="{{ route('videos.show', $video->id) }}">
                        <img src="{{ Storage::url($video->thumbnail) }}" class="card-img-top" alt="{{ $video->title }}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('videos.show', $video->id) }}" class="text-dark">
                                {{ Str::limit($video->title, 50) }}
                            </a>
                        </h5>
                        <p class="card-text text-muted">
                            {{ Str::limit($video->description, 80) }}
                        </p>
                        <p class="card-text">
                            <small class="text-muted">{{ $video->published_at}}</small>
                        </p>
                        @if(auth()->user()->role->name == 'admin')
                                                <!-- Formulaire de suppression -->
                                                <form action="{{ route('videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette vidéo ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            <a href="{{ route('videos.edit', $video->id) }}" class="btn btn-warning">Modifier</a>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
