@extends('layouts.app')

@section('title', 'Créer une nouvelle catégorie')

@section('content')
<div class="container" style="width: 100%; margin: 0; padding: 0;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Créer une Nouvelle Catégorie</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nom de la catégorie <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Entrez le nom de la catégorie" value="{{ old('name') }}" required>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
