@extends('layouts.app')

@section('title', 'Détails du Projet - ' . $project->title)

@section('content')

<style>
    .horizontal-sidebar {
    background-color: #f8f9fa;
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}

.horizontal-sidebar .nav-tabs {
    border-bottom: none;
    justify-content: center;
}

.horizontal-sidebar .nav-tabs .nav-link {
    color: #333;
    font-size: 16px;
    padding: 10px 20px;
    border-radius: 0;
    transition: all 0.3s ease;
}

.horizontal-sidebar .nav-tabs .nav-link.active {
    background-color: #27ae60;
    color: #fff;
    font-weight: bold;
}


.task-box {
        background-color: rgba(39, 174, 96, 0.1);
        border: 1px solid #27ae60;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .task-box:hover {
        background-color: rgba(39, 174, 96, 0.2);
    }
    .task-cards {
        display: none;
    }
    .task-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin: 10px 0;
        background-color: #fff;
        box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
    }

    .status-box {
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    font-weight: bold;
    color: #000; /* Texte en noir */
    margin-bottom: 20px;
    transition: 0.3s;
    background: rgba(255, 255, 255, 0.6); /* Blanc avec 60% d'opacité */
    border: 2px solid transparent; /* Bordure par défaut */
    backdrop-filter: blur(5px); /* Effet de flou pour un meilleur rendu */
}

/* Couleurs semi-transparentes pour chaque statut */
.pending { background: rgba(255, 193, 7, 0.3); border-color: rgba(255, 193, 7, 0.8); }  /* Jaune - En attente */
.in-progress { background: rgba(0, 123, 255, 0.3); border-color: rgba(0, 123, 255, 0.8); } /* Bleu - En cours */
.completed { background: rgba(40, 167, 69, 0.3); border-color: rgba(40, 167, 69, 0.8); } /* Vert - Accompli */
.not-completed { background: rgba(220, 53, 69, 0.3); border-color: rgba(220, 53, 69, 0.8); } /* Rouge - Non accompli */

/* Style du bouton "Ouvrir" */
.status-box button {
    background: rgba(40, 167, 69, 0.9); /* Vert */
    border: none;
    padding: 10px 15px;
    color: white;
    cursor: pointer;
    border-radius: 5px;
    transition: 0.3s;
    font-weight: bold;
}

.status-box button:hover {
    background: rgba(40, 167, 69, 1); /* Vert plus foncé au survol */
}


</style>
<div class="container">
    <div class="horizontal-sidebar">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('coach.projects.index') ? 'active' : '' }}" href="{{ route('coach.projects.index') }}">
                    Projets à coacher
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('mentorship_sessions.index') ? 'active' : '' }}" href="{{ route('mentorship_sessions.index') }}">
                    Séances de mentorat
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('profile.view') ? 'active' : '' }}" href="{{ route('profile.view') }}">
                    Mon Profil
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('report.generate') ? 'active' : '' }}" href="{{ route('report.generate') }}">
                    Systéme de reporting
                </a>
            </li>
        </ul>
    </div>
    <div class="workspace-content mt-4">
        @yield('workspace-content')
    </div>
</div>




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
            <h1 class="h3 mb-0 text-gray-800" 
          style="background-color: rgba(39, 174, 96, 0.1); 
           color: #606060 ; 
           border: 1px solid #27ae60; 
           padding: 10px 15px; 
           border-radius: 5px; 
           display: inline-block; 
           margin: 0 auto; 
           text-align: center; 
           width: 100%;">
                Tâches Associées au Projet : <span class="text-primary">{{ $project->title }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <!-- Bouton pour ouvrir le modal -->
                    <button class="btn btn-md" style="background-color: #27ae60     ; color: white;" data-toggle="modal" data-target="#addTaskModal">
                        Ajouter une Nouvelle Tâche
                    </button>
                    </h1>
        </div>
        </div>
        </div>

        <div class="row"> 
    <div class="col-md-3">
        <div class="status-box pending">
            <i class="fas fa-clock"></i>
            <h3>En attente</h3>
            <button onclick="showTasks('pending')">Ouvrir</button>
        </div>
    </div>
    <div class="col-md-3">
        <div class="status-box in-progress">
            <i class="fas fa-spinner"></i>
            <h3>En cours</h3>
            <button onclick="showTasks('in_progress')">Ouvrir</button>
        </div>
    </div>
    <div class="col-md-3">
        <div class="status-box completed">
            <i class="fas fa-check-circle"></i>
            <h3>Accompli</h3>
            <button onclick="showTasks('completed')">Ouvrir</button>
        </div>
    </div>
    <div class="col-md-3">
        <div class="status-box not-completed">
            <i class="fas fa-times-circle"></i>
            <h3>Non accompli</h3>
            <button onclick="showTasks('not_completed')">Ouvrir</button>
        </div>
    </div>
</div>


                                            <div id="task-container" class="mt-4">
                                                <div id="pending" class="task-cards">
                                                <div class="row">
                                                    @foreach ($project->tasks->where('status', 'en attente') as $task)
                                                        @include('partials.task_card', ['task' => $task])
                                                    @endforeach
                                                    </div>
                                                </div>
                                                <div id="in_progress" class="task-cards">
                                                <div class="row">
                                                    @foreach ($project->tasks->where('status', 'en cours') as $task)
                                                        @include('partials.task_card', ['task' => $task])
                                                    @endforeach
                                                    </div>
                                                </div>
                                                <div id="completed" class="task-cards" >
                                                <div class="row">
                                                    @foreach ($project->tasks->where('status', 'soumis') as $task)
                                                        @include('partials.task_card', ['task' => $task])
                                                    @endforeach
                                                    </div>
                                                </div>
                                                <div id="not_completed" class="task-cards">
                                                <div class="row">
                                                    @foreach ($project->tasks->where('status', 'non accompli') as $task)
                                                        @include('partials.task_card', ['task' => $task])
                                                    @endforeach
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
<script>
    function showTasks(status) {
        document.querySelectorAll('.task-cards').forEach(el => el.style.display = 'none');
        document.getElementById(status).style.display = 'block';
    }
</script>
@endsection
