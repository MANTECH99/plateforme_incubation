@extends('layouts.app')

@section('title', 'Créer un Nouveau Projet')

@section('content')
<div class="content-body" style="width: 100%; margin: 0; padding: 0;">

    <div class="container-fluid p-0 w-100" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Créer un Nouveau Projet</h1>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3" style="background-color: #4CAF50     ; color: white;">
                        <h6 class="m-0 font-weight-bold" style="color: white;">Détails du Projet</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ auth()->user()->role->name === 'coach' ? route('coach.projects.store') : route('porteur.projects.store') }}">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="title" class="form-label font-weight-bold">Titre du Projet</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Entrez le titre du projet" required>
                            </div>

                            <div class="form-group mb-4">
                                <label for="description" class="form-label font-weight-bold">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="5" placeholder="Entrez une description détaillée du projet" required></textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success btn-md"><i class="fa fa-check"></i> Créer le Projet</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
