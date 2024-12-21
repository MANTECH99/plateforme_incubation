@extends('layouts.app')

@section('title', 'Dashboard - Plateforme incubation')

@section('content')

<div class="content-body" style="width: 100%; margin: 0; padding: 0;">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb bg-light px-3 py-2 rounded">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Mes projets</a></li>
            </ol>
        </div>
    </div>

    <!-- Bouton de création -->
    <div class="mb-4">
        <a href="{{ route('porteur.projects.create') }}" class="btn btn-success btn-sm">
            <i class="fa fa-plus"></i> Créer un Nouveau Projet
        </a>
    </div>

    <!-- Titre principal -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mes projets et Tâches associées</h1>
    </div>

    <!-- Tableau des projets -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered align-items-center table-flush text-center">
                    <thead style="background-color: #3498db; color: white;">

                            <tr>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Coach</th>
                                <th>Tâches associées</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($projects as $project)
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>{{ $project->description }}</td>
                                    <td>{{ $project->coach->name ?? 'Non assigné' }}</td>
                                    <td>
                                        <a href="{{ route('porteur.projects.tasks', ['project' => $project->id]) }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-tasks"></i> Voir Détails
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucun projet disponible.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-light text-center">
                    <small class="text-muted">Dernière mise à jour : {{ now()->format('d/m/Y') }}</small>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
