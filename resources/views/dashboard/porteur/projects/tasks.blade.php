@extends('layouts.app')

@section('title', 'Dashboard - Plateforme incubation')

@section('content')

<div class="content-body" style="width: 100%; margin: 0; padding: 0;">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb bg-light px-3 py-2 rounded">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Tâches pour le projet : {{ $project->title }}</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid p-0 w-100" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tâches Associées au Projet : <span class="text-primary">{{ $project->title }}</span></h1>
        </div>

        @if($tasks->count() > 0)
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card shadow">
                        <div class="table-responsive">
                            <table class="table align-items-center table-bordered">
                                <thead  style="background-color: #27ae60; color: white;">
                                    <tr>
                                        <th style="border: 1px solid #2ecc71;">Titre</th>
                                        <th style="border: 1px solid #2ecc71;">Description</th>
                                        <th style="border: 1px solid #2ecc71;">Travail à faire</th>
                                        <th style="border: 1px solid #2ecc71;">Deadline</th>
                                        <th style="border: 1px solid #2ecc71;">Status</th>
                                        <th style="border: 1px solid #2ecc71;">Progression</th>
                                        <th style="border: 1px solid #2ecc71;">Soumission du travail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td>{{ $task->title }}</td>
                                            <td>{{ $task->description }}</td>
                                            <td>
                @if ($task->to_do_file)
                    <a href="{{ Storage::url($task->to_do_file) }}" target="_blank" class="btn btn-sm btn-primary">Voir le fichier</a>
                    <a href="{{ Storage::url($task->to_do_file) }}" download class="btn btn-sm btn-success">Télécharger</a>
                @else
                    <span class="text-muted">Aucun fichier fourni</span>
                @endif
            </td>
                                            <td>{{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Non définie' }}</td>
                                            <td>
                                            @if ($task->due_date && now()->greaterThan($task->due_date) && $task->status != 'soumis')
        @php
            $task->status = 'non accompli'; // Met à jour localement pour refléter le statut
        @endphp
    @endif
    @if ($task->status == 'soumis')
        <span class="badge badge-success">Soumis</span>
    @elseif ($task->status == 'non accompli')
        <span class="badge badge-danger">Non accompli</span>
    @elseif ($task->status == 'en cours')
        <span class="badge badge-primary">En cours</span>
    @else
        <span class="badge badge-warning">{{ ucfirst($task->status) }}</span>
    @endif
</td>

<td>
<!-- Barre de progression -->
<div class="progress mt-2" style="height: 20px; background-color: #f3f3f3; border-radius: 10px; overflow: hidden;">
    <div 
        class="progress-bar progress-bar-striped progress-bar-animated 
            @if ($task->status == 'soumis') 
                bg-success 
            @elseif ($task->status == 'non accompli') 
                bg-danger 
            @else 
                bg-info 
            @endif" 
        role="progressbar" 
        style="width: {{ $task->status == 'soumis' ? 100 : $task->progress }}%;" 
        aria-valuenow="{{ $task->status == 'soumis' ? 100 : $task->progress }}" 
        aria-valuemin="0" 
        aria-valuemax="100">
        {{ $task->status == 'soumis' ? 100 : $task->progress }}%
    </div>
</div>

</td>

    <td>
    @if ($task->submission)
        <!-- Lien pour voir ou télécharger le fichier -->
        <a href="{{ Storage::url($task->submission) }}" target="_blank" class="btn btn-sm btn-primary">
            Voir le fichier
        </a>
        <a href="{{ Storage::url($task->submission) }}" download class="btn btn-sm btn-success">
            Télécharger
        </a>
    @elseif ($task->due_date && now()->greaterThan($task->due_date))
        <!-- Message si la date d'échéance est dépassée -->
        <span class="btn btn-sm btn-danger">Echéance dépassée</span>
    @else
        <!-- Formulaire pour soumettre le travail -->
        <form method="POST" action="{{ route('porteur.tasks.submit', $task->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="file" name="submission" class="form-control mb-2" required>
            </div>
            <button type="submit" class="btn btn-sm btn-success">Soumettre</button>
        </form>
    @endif
</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-center">
                            <p class="mb-0">Total des tâches : <span class="font-weight-bold">{{ $tasks->count() }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center">
                Aucune tâche n'est disponible pour ce projet pour le moment.
            </div>
        @endif
    </div>
</div>
@endsection
