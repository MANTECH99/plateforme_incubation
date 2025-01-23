@extends('layouts.app')

@section('title', 'Dashboard - Plateforme incubation')

@section('content')
<div class="content-body" style="width: 100%; margin: 0; padding: 0;">

    <div class="container-fluid p-0 w-100" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Ajouter une Ressource</h1>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <!-- Formulaire d'ajout de ressource -->
                <div class="card shadow">
                    <div class="card-header" style="background-color: #4CAF50     ; color: white;">
                        <h6 class="m-0 font-weight-bold" style=" color: white;">Formulaire d'Ajout de Ressource</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('resources.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="title" class="font-weight-bold">Titre :</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Entrez le titre de la ressource" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="type" class="font-weight-bold">Type :</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="document">Document</option>
                                    <option value="formation">Formation</option>
                                    <option value="outil">Outil</option>
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label for="file" class="font-weight-bold">Fichier :</label>
                                <input type="file" name="file" id="file" class="form-control-file">
                            </div>

                            <div class="form-group mt-3">
                                <label for="description" class="font-weight-bold">Description :</label>
                                <textarea name="description" id="description" class="form-control" placeholder="Ajoutez une description" rows="4"></textarea>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success">Ajouter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

