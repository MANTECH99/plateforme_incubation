@extends('layouts.app')

@section('title', 'Dashboard - Plateforme incubation')

@section('content')
<style>
.custom-event {
    font-weight: bold !important; /* Texte en gras */
    color: #27ae60 !important; /* Texte en noir */
}

.fc-prev-button, .fc-next-button {
    color: black !important; /* Change la couleur des flèches */
    background-color: transparent; /* Supprime le fond */
    border: none; /* Supprime les bordures */
}

.fc-prev-button:hover, .fc-next-button:hover {
    color: #27ae60 !important; /* Couleur au survol */
}


/* Styles généraux pour les boutons */
.fc-button {
    color: black !important; /* Texte noir */
    background-color: transparent; /* Fond transparent */
    border: 1px solid #27ae60; /* Bordure verte */
}

/* Bouton actif (sélectionné) */
.fc-button.fc-button-active {
    color: white !important; /* Texte blanc */
    background-color: #27ae60 !important; /* Fond vert */
    border-color: #27ae60 !important; /* Bordure verte */
}

/* Boutons au survol */
.fc-button:hover {
    color: white !important; /* Texte blanc */
    background-color: #2ecc71 !important; /* Fond vert clair */
    border-color: #2ecc71 !important; /* Bordure vert clair */
}


</style>
<div class="card mt-4">
    <div class="btn btn-lg" style="background-color: #27ae60     ; color: white;">
        Sélectionner un Porteur de Projet
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('coach.dashboard') }}">
            <div class="form-group">
                <label for="porteuse_id">Choisir un Porteur de Projet :</label>
                <select name="porteuse_id" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Sélectionner --</option>
                    @foreach($porteuses as $porteuse)
                        <option value="{{ $porteuse->id }}" {{ request('porteuse_id') == $porteuse->id ? 'selected' : '' }}>
                            {{ $porteuse->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

@if($selectedPorteur)
    <!-- Afficher le graphique de progression globale des projets du porteur -->
    <div class="card mt-4">
        <div class="btn btn-lg" style="background-color: #27ae60     ; color: white;">
            Progression Globale des Projets de {{ $selectedPorteur->name }}
        </div>
        <div class="card-body">
            <canvas id="coachProgressChart" width="10" height="2"></canvas>
        </div>
    </div>

    <!-- Afficher la sélection d'un projet pour afficher l'état d'avancement des tâches -->
    <div class="card mt-4">
        <div class="btn btn-lg" style="background-color: #27ae60     ; color: white;">
            Sélectionner un Projet pour Voir l'État d'Avancement des Tâches
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('coach.dashboard') }}">
                <div class="form-group">
                    <label for="project_id">Choisir un Projet :</label>
                    <select name="project_id" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Sélectionner --</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->title }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="porteuse_id" value="{{ request('porteuse_id') }}">
                </div>
            </form>
        </div>
    </div>

    @if(request('project_id'))
        <!-- Afficher le graphique de progression des tâches du projet sélectionné -->
        <div class="card mt-4">
            <div class="btn btn-lg">
                État d'Avancement des Tâches pour le Projet {{ $selectedProject->title }}
            </div>
            <div class="card-body">
                <canvas id="tasksProgressChart" width="10" height="2"></canvas>
            </div>
        </div>
    @endif
@endif

    <!-- Calendrier des Séances -->
    <div class="col-12 mt-5">
        <div class="card shadow">
            <div class="card-header py-3" style="background-color: #27ae60     ; color: white;">
                <h4 class="m-0 font-weight-bold" style=" color: white;">Calendrier des Séances de Mentorat</h4>
            </div>
            <div class="card-body">
                <div id="calendar" style="margin-bottom: 30px;"></div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Graphique de progression globale des projets
        const projectTitles = @json($projects->pluck('title'));
        const projectProgress = @json($projects->map(fn($p) => $p->tasks->count() > 0 ? round($p->tasks->sum('progress') / $p->tasks->count()) : 0));

        const ctx1 = document.getElementById('coachProgressChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: projectTitles,
                datasets: [{
                    label: 'Progression des Projets (%)',
                    data: projectProgress,
                    backgroundColor: projectProgress.map(progress => {
                        if (progress < 50) return 'rgba(255, 0, 0, 0.3)'; // Rouge transparent
                        if (progress >= 50 && progress < 100) return 'rgba(0, 123, 255, 0.3)'; // Bleu transparent
                        return 'rgba(40, 167, 69, 0.3)'; // Vert transparent
                    }),
                    borderColor: '#ffffff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: { display: true, text: 'Projets' },
                    },
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Progression (%)' },
                        ticks: {
                            stepSize: 20
                        }
                    }
                }
            }
        });

        // Graphique de progression des tâches
        const taskStats = @json($taskStats);

        const ctx2 = document.getElementById('tasksProgressChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['En attente', 'En cours', 'Accompli', 'Non accompli'],
                datasets: [{
                    label: 'Nombre de tâches',
                    data: [taskStats.en_attente, taskStats.en_cours,  taskStats.soumis, taskStats.non_accompli],
                    backgroundColor: [
                        'rgba(255, 193, 7, 0.3)',  // Jaune clair
                        'rgba(0, 123, 255, 0.8)',  // bleu
                        'rgba(40, 167, 69, 0.3)',  // Vert clair
                        'rgba(220, 53, 69, 0.3)'   // Rouge clair
                    ],
                    borderColor: [
                        'rgba(255, 193, 7, 1)', 
                        'rgba(0, 123, 255, 0.8)',  // bleu
                        'rgba(40, 167, 69, 1)', 
                        'rgba(220, 53, 69, 1)' 
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Statut des tâches'
                        },
                        ticks: {
                            color: '#333'
                        },
                        barPercentage: 0.1,
                        categoryPercentage: 0.6
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Nombre de tâches'
                        },
                        ticks: {
                            color: '#333'
                        }
                    }
                }
            }
        });
    });
</script>

@endsection
