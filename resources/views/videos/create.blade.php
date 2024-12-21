@extends('layouts.app')

@section('content')
<div class="container" style="width: 100%; margin: 0; padding: 0;">
    <h1>Ajouter une Vidéo</h1>
    <form method="POST" action="{{ route('videos.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="category_id">Catégorie</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="thumbnail">Miniature</label>
            <input type="file" name="thumbnail" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="video_path">Vidéo</label>
            <input type="file" name="video_path" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="published_at">Date de publication</label>
            <input type="date" name="published_at" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
    </form>
</div>
@endsection
