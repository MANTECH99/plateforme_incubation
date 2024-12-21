@extends('layouts.app')

@section('content')
<div class="container" style="width: 100%; margin: 0; padding: 0;">
    <h1>Modifier la Vidéo</h1>
    <form method="POST" action="{{ route('videos.update', $video->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Utiliser la méthode PUT pour la mise à jour -->
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" name="title" class="form-control" value="{{ $video->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control">{{ $video->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="category_id">Catégorie</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ $video->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="thumbnail">Miniature (Laisser vide si inchangée)</label>
            <input type="file" name="thumbnail" class="form-control">
        </div>
        <div class="form-group">
            <label for="video_path">Vidéo (Laisser vide si inchangée)</label>
            <input type="file" name="video_path" class="form-control">
        </div>
        <div class="form-group">
            <label for="published_at">Date de publication</label>
            <input type="date" name="published_at" class="form-control" value="{{ $video->published_at }}">
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
