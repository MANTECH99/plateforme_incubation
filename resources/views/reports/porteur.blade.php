@extends('layouts.app')

@section('title', 'Rapport du Porteur de Projet')

@section('content')
    <style>#statusChart {
            max-height: 310px !important; /* Réduire la hauteur */
        }

        #projectsBySectorChart {
            max-height: 340px !important; /* Réduire la hauteur */
        }
    </style>
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


        <div class="container-fluid p-0 m-0" style="min-height: 100vh;">
        <h1 class="mb-4">Rapport Statistique pour {{ $porteur->name }}</h1>
        <div class="mb-4">
            <a href="{{ route('report.porteur.export', ['porteurId' => $porteur->id, 'format' => 'pdf']) }}"
               class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Exporter en PDF
            </a>
            <a href="{{ route('report.porteur.export', ['porteurId' => $porteur->id, 'format' => 'excel']) }}"
               class="btn btn-success">
                <i class="fas fa-file-excel"></i> Exporter en Excel
            </a>
        </div>
        <!-- Statistiques globales -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total des Projets</h5>
                        <p class="card-text h3">{{ $totalProjects }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Projets Terminés</h5>
                        <p class="card-text h3">{{ $completedProjects }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Projets En Cours</h5>
                        <p class="card-text h3">{{ $ongoingProjects }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Détails des projets -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Projets</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Statut</th>
                        <th>Budget</th>
                        <th>Tâches</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->title }}</td>
                            <td>{{ $project->status }}</td>
                            <td>{{ number_format($project->budget) }} FCFA</td>
                            <td>{{ $project->tasks->count() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Statistiques des tâches -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Tâches</h5>
            </div>
            <div class="card-body">
                <p><strong>Total des tâches :</strong> {{ $totalTasks }}</p>
                <p><strong>Tâches terminées :</strong> {{ $completedTasks }}</p>
                <p><strong>Tâches en retard :</strong> {{ $overdueTasks }}</p>
            </div>
        </div>

        <!-- Sessions de mentorat -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Sessions de Mentorat</h5>
            </div>
            <div class="card-body">
                <p><strong>Total des sessions :</strong> {{ $totalMentorshipSessions }}</p>
            </div>
        </div>
    </div>

    <!-- Statistiques globales -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(to right, #27ae60, #27ae60); color: white">
                    Statistiques Globales
                </div>
                <div class="card-body">
                    <p><strong>Budget total :</strong> {{ number_format($totalBudget) }} FCFA</p>
                    <p><strong>Projets terminés :</strong> {{ $completedProjects }}</p>
                    <p><strong>Projets en cours :</strong> {{ $ongoingProjects }}</p>
                    <p><strong>Projets à venir :</strong> {{ $upcomingProjects }}</p>
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Projets par secteur -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(to right, #27ae60, #27ae60); color: white">
                    Projets par Secteur
                </div>
                <div class="card-body">
                    <canvas id="projectsBySectorChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Projets par mois -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    Projets Créés par Mois
                </div>
                <div class="card-body">
                    <canvas id="projectsByMonthChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Rapport mensuel -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(to right, #27ae60, #27ae60); color: white">
                    Rapport Mensuel ({{ date('F Y', mktime(0, 0, 0, (int) $selectedMonth, 1, (int) $selectedYear)) }})
                </div>
                <div class="card-body">
                    <p><strong>Projets créés :</strong> {{ $monthlyProjects->count() }}</p>
                    <p><strong>Tâches terminées :</strong> {{ $completedTasks }}</p>
                    <p><strong>Tâches en cours :</strong> {{ $tasksInProgress }}</p>
                    <p><strong>Tâches en retard :</strong> {{ $overdueTasks }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Évolution des projets -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    Évolution des Projets
                </div>
                <div class="card-body">
                    <canvas id="projectsOverTimeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tâches en retard -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(to right, #27ae60, #27ae60); color: white">
                    Tâches en Retard
                </div>
                <div class="card-body">
                    <h5 class="text-danger">{{ $overdueTasks }}</h5>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Scripts pour les graphiques -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Données pour le graphique des statuts
        const statusData = {
            labels: @json(['Terminés', 'En cours', 'À venir']),
            datasets: [{
                label: 'Nombre de Projets',
                data: @json([$completedProjects, $ongoingProjects, $upcomingProjects]),
                backgroundColor: ['#4caf50', '#ff9800', '#f44336'],
            }]
        };

        // Graphique des statuts
        new Chart(document.getElementById('statusChart'), {
            type: 'pie',
            data: statusData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // Graphique des projets par secteur
        new Chart(document.getElementById('projectsBySectorChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($projectStats['by_sector']->keys()) !!},
                datasets: [{
                    data: {!! json_encode($projectStats['by_sector']->values()) !!},
                    backgroundColor: ['#27ae60', '#2ecc71', '#16a085', '#1abc9c', '#2980b9']
                }]
            }
        });

        // Graphique des projets par mois
        const projectsByMonthData = {
            labels: @json($monthlyProjectsStats->pluck('month_name')),
            datasets: [{
                label: 'Projets par Mois',
                data: @json($monthlyProjectsStats->pluck('count')),
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            }]
        };

        new Chart(document.getElementById('projectsByMonthChart'), {
            type: 'bar',
            data: projectsByMonthData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });

        // Graphique de l'évolution des projets
        new Chart(document.getElementById('projectsOverTimeChart'), {
            type: 'line',
            data: {
                labels: @json($projectStats['over_time']->pluck('date')),
                datasets: [{
                    label: 'Nombre de projets',
                    data: @json($projectStats['over_time']->pluck('total')),
                    borderColor: '#27ae60',
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>



@endsection
