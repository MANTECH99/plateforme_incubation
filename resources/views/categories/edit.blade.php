
@extends('layouts.app')

@section('title', 'Éditer la catégorie')

@section('content')
    <div class="container">
        <h1>Éditer la catégorie</h1>

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PATCH') <!-- Utilisation de PATCH -->
    <div class="form-group">
        <label for="name">Nom de la catégorie</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Mettre à jour</button>
</form>


    </div>
@endsection
