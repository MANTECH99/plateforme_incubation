@extends('layouts.app')

@section('title', 'Détails du Projet - ' . $project->title)

@section('content')
<div class="content-body" style="width: 100%; margin: 0; padding: 0;">

    <!-- Informations sur le projet -->
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header py-3" style="background-color: #27ae60; color: white;">
                <h6 class="m-0 font-weight-bold" style=" color: white;">Informations sur le Projet : {{ $project->title }}</h6>
            </div>
            <div class="card-body">
                <p><strong>Description :</strong> {{ $project->description }}</p>
            </div>
        </div>
    </div>

    <!-- Section Tâches -->
    <div class="container-fluid mt-4">
        <div class="card shadow">
            <div class="card-header py-3" >
                <h6 class="m-0 font-weight-bold d-flex justify-content-between align-items-center">
                    Tâches Associées
                    <!-- Bouton pour ouvrir le modal -->
                    <button class="btn btn-md" style="background-color: #27ae60     ; color: white;" data-toggle="modal" data-target="#addTaskModal">
                        Ajouter une Nouvelle Tâche
                    </button>
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead style="background-color: #27ae60; color: white;">
                        <tr>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Travail à faire</th>
                            <th>Statut</th>
                            <th>Échéance</th>
                            <th>Progression</th>
                            <th>Soumission du travail</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($project->tasks as $task)
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
                                <td>
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
                                <td>{{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Non définie' }}</td>
                                <td>
                                    <div class="progress mt-2" style="height: 20px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated 
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
                                        <a href="{{ Storage::url($task->submission) }}" target="_blank" class="btn btn-sm btn-primary">Voir le fichier</a>
                                        <a href="{{ Storage::url($task->submission) }}" download class="btn btn-sm btn-success">Télécharger</a>
                                    @else
                                        <p class="btn btn-sm btn-danger">Tache non encore soumis</p>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editTaskModal{{ $task->id }}">Modifier</button>
                                    <form method="POST" action="{{ route('coach.tasks.destroy', [$project->id, $task->id]) }}" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                    </form>

                                                                        <!-- Modal de modification -->
                                                                        <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel{{ $task->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: #27ae60; color: white;">
                                                    <h5 class="modal-title">Modifier la Tâche</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('coach.tasks.update', [$project->id, $task->id]) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="form-group">
                                                            <label for="title">Titre</label>
                                                            <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="description">Description</label>
                                                            <textarea name="description" class="form-control">{{ $task->description }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="status">Statut</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value="en attente" {{ $task->status === 'en attente' ? 'selected' : '' }}>En attente</option>
                                                                <option value="en cours" {{ $task->status === 'en cours' ? 'selected' : '' }}>En cours</option>
                                                                <option value="terminé" {{ $task->status === 'terminé' ? 'selected' : '' }}>Terminé</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="due_date">Échéance</label>
                                                            <input type="date" name="due_date" class="form-control" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-success">Mettre à jour</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal d'ajout de tâche -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #27ae60; color: white;">
                    <h5 class="modal-title" id="addTaskModalLabel" style=" color: white;">Ajouter une Nouvelle Tâche</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('coach.tasks.store', $project->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Titre de la Tâche</label>
                            <input type="text" name="title" class="form-control" placeholder="Titre de la tâche" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" placeholder="Description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="to_do_file">Fichier du travail à effectuer (optionnel)</label>
                            <input type="file" name="to_do_file" class="form-control" accept=".pdf,.doc,.docx,.xlsx,.png,.jpg,.jpeg,.zip,.rar">
                            <small class="form-text text-muted">Formats acceptés : PDF, Word, Excel, Images, ZIP, etc.</small>
                        </div>
                        <div class="form-group">
                            <label for="status">Statut</label>
                            <select name="status" class="form-control" required>
                                <option value="en attente">En attente</option>
                                <option value="en cours">En cours</option>
                                <option value="terminé">Terminé</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="due_date">Échéance</label>
                            <input type="date" name="due_date" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success" style="background-color: #27ae60; color: white;">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
