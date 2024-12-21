@extends('layouts.app')

@section('content')
<style>
    /* Styles personnalisés pour les playlists */
    .card img {
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }

    .card {
        border: none;
        background-color: #f9f9f9;
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 10px;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    }

    .card-title a {
        font-size: 1.1rem;
        font-weight: bold;
        color: #333;
        text-decoration: none;
    }

    .card-title a:hover {
        color: #007bff;
    }

    .card-text {
        font-size: 0.9rem;
        color: #666;
    }

    .playlist-count {
        font-size: 0.8rem;
        color: #999;
    }

    .container h1 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 30px;
        text-align: center;
    }
</style>
@if(auth()->user()->role->name == 'admin')
<div class="mb-3">
<a href="{{ route('categories.create') }}" class="btn btn-primary">Ajouter une Catégorie</a>
<a href="{{ route('videos.create') }}" class="btn btn-primary">Ajouter une Vidéo</a>
</div>
@endif
<a href="{{ route('videos.index') }}" class="btn btn-secondary">Voir toutes les Vidéos</a>
<div class="container" style="width: 100%; margin: 0; padding: 0;">
    <h1>Playlists</h1>
    <div class="row g-4">
        @foreach ($categories as $category)
            <div class="col-md-4 col-sm-6">
                <div class="card">
                    <!-- La miniature de la playlist -->
                    <a href="{{ route('categories.show', $category->id) }}">
                        <img src="{{ $category->videos->first() ? Storage::url($category->videos->first()->thumbnail) : 'default-thumbnail.jpg' }}" 
                             class="card-img-top" 
                             alt="{{ $category->name }}">
                    </a>
                    <div class="card-body text-center">
                        <!-- Titre de la playlist -->
                        <h5 class="card-title">
                            <a href="{{ route('categories.show', $category->id) }}">
                                {{ Str::limit($category->name, 30) }}
                            </a>
                        </h5>
                        <!-- Nombre de vidéos -->
                        <p class="playlist-count">{{ $category->videos->count() }} vidéos</p>
                        @if(auth()->user()->role->name == 'admin')
                                                <!-- Boutons Modifier et Supprimer -->
                                                <div class="d-flex justify-content-center gap-2 mt-3">
                            <!-- Bouton Modifier -->
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-edit btn-action">
                                Modifier
                            </a>
                            <!-- Bouton Supprimer -->
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette playlist ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete btn-action">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
