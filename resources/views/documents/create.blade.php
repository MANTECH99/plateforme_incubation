@extends('layouts.app')

@section('title', 'Dashboard - Plateforme incubation')

@section('content')
    <div class="content-body" style="width: 100%; margin: 0; padding: 0;">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb bg-light px-3 py-2 rounded">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Ajouter un Document</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid p-0 w-100" id="container-wrapper" style="margin: 0; padding: 0; width: 100%;">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Ajouter un Document</h1>
            </div>

            <div class="row">
                <div class="col-lg-12 mb-4">
                    <!-- Formulaire d'ajout de document -->
                    <div class="card">
                        <div class="card-header py-3 text-white" style="background-color: #27ae60;">
                            <h6 class="m-0 font-weight-bold">Formulaire d'ajout de document</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="title" class="font-weight-bold">Titre :</label>
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="description" class="font-weight-bold">Description :</label>
                                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="file" class="font-weight-bold">Fichier :</label>
                                    <input type="file" name="file" id="file" class="form-control-file" required>
                                </div>

                                <div class="form-group mt-4">
                                    <label for="shared_with" class="font-weight-bold">Partager avec :</label>
                                    <div id="shared_with_groups" class="p-3 border rounded bg-light">
                                        <p class="text-muted">Sélectionnez les utilisateurs avec lesquels vous souhaitez partager le document.</p>

                                        <div class="mt-3">
                                            <h5>Coachs</h5>
                                            <select name="shared_with[]" id="shared_with_coaches" class="form-control" multiple>
                                                @foreach ($coaches as $coach)
                                                    <option value="{{ $coach->id }}">{{ $coach->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mt-3">
                                            <h5>Porteurs de Projets</h5>
                                            <select name="shared_with[]" id="shared_with_porteurs" class="form-control" multiple>
                                                @foreach ($porteurs as $porteur)
                                                    <option value="{{ $porteur->id }}">{{ $porteur->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-4">Partager</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

