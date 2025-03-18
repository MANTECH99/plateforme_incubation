<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="fas fa-tasks me-2"></i>&nbsp;&nbsp;
                    <h5 class="mb-0">{{ $task->title }}</h5>
                </div>
                <div class="card-body">
                    <p><i class="fas fa-align-left"></i> <strong>Description :</strong> {{ $task->description }}</p>
                    <p><i class="fas fa-file-alt"></i> <strong>Travail à faire :</strong> 
                        @if ($task->to_do_file)
                            <a href="{{ Storage::url($task->to_do_file) }}" target="_blank" class="btn btn-sm btn-primary">Voir</a>
                            <a href="{{ Storage::url($task->to_do_file) }}" download class="btn btn-sm btn-success">Télécharger</a>
                        @else
                            <span class="text-muted">Aucun fichier fourni</span>
                        @endif
                    </p>
                    <p><i class="fas fa-info-circle"></i> <strong>Statut :</strong> 
                        <span class="badge 
                            @if ($task->status == 'soumis') badge-success
                            @elseif ($task->status == 'non accompli') badge-danger
                            @elseif ($task->status == 'en cours') badge-primary
                            @else badge-warning
                            @endif">
                            {{ ucfirst($task->status) }}
                        </span>
                    </p>
                    <p><i class="fas fa-calendar-alt"></i> <strong>Échéance :</strong> 
                        {{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Non définie' }}
                    </p>

                    <!-- Progression sur la même ligne -->
                    <div class="d-flex align-items-center">
                        <p class="mb-0 me-2"><i class="fas fa-chart-line"></i> <strong>Progression : </strong></p>&nbsp;
                        <div class="progress flex-grow-1" style="height: 15px; max-width: 200px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated 
                                @if ($task->status == 'soumis') bg-success
                                @elseif ($task->status == 'non accompli') bg-danger
                                @else bg-info
                                @endif" 
                                role="progressbar" 
                                style="width: {{ $task->status == 'soumis' ? 100 : $task->progress }}%;" 
                                aria-valuenow="{{ $task->status == 'soumis' ? 100 : $task->progress }}" 
                                aria-valuemin="0" 
                                aria-valuemax="100">
                                {{ $task->status == 'soumis' ? 100 : $task->progress }}%
                            </div>
                        </div>
                    </div>

                    <!-- Soumission alignée -->
                    <div class="d-flex align-items-center mt-3">
                        <p class="mb-0 me-2"><i class="fas fa-upload"></i> <strong>Soumission du travail : </strong></p>&nbsp;&nbsp;
                        <div>
                            @if ($task->submission)
                                <a href="{{ Storage::url($task->submission) }}" target="_blank" class="btn btn-sm btn-primary">Voir</a>
                                <a href="{{ Storage::url($task->submission) }}" download class="btn btn-sm btn-success">Télécharger</a>
                            @elseif ($task->due_date && now()->greaterThan($task->due_date))
                                <span class="btn btn-sm btn-danger">Échéance dépassée</span>
                            @else
                                <form method="POST" action="{{ route('porteur.tasks.submit', $task->id) }}" enctype="multipart/form-data" class="d-flex">
                                    @csrf
                                    <input type="file" name="submission" class="form-control form-control-sm me-2" required style="max-width: 200px;">&nbsp;&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-sm btn-success">Soumettre</button>
                                </form>
                            @endif
                        </div>
                    </div><br>
                    @if(auth()->user()->role->name == 'coach')
                    <form method="POST" action="{{ route('coach.tasks.destroy', [$project->id, $task->id]) }}" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp; Supprimer</button>
                                    </form>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editTaskModal{{ $task->id }}"><i class="fa fa-edit"></i>&nbsp; Modifier</button>&nbsp;&nbsp;&nbsp;
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
                                    @endif
                </div>
            </div>
        </div>
