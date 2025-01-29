@extends('layouts.app')

@section('title', 'Rapport Statistique')

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
        <h1 class="mb-4 text-center">Rapport Statistique</h1>

        <form method="GET" action="{{ route('report.generate') }}" class="mb-4">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label for="period" class="form-label">Période :</label>
                    <select name="period" id="period" class="form-select" onchange="toggleDateSelection()">
                        <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Cette semaine</option>
                        <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Ce mois</option>
                        <option value="quarter" {{ request('period') == 'quarter' ? 'selected' : '' }}>Ce trimestre</option>
                        <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>Cette année</option>
                        <option value="custom" {{ request('period') == 'custom' ? 'selected' : '' }}>Période personnalisée</option>
                        <option value="specific" {{ request('period') == 'specific' ? 'selected' : '' }}>Mois/Année spécifique</option>
                    </select>
                </div>
                <div class="col-md-4" id="customDate" style="display: none;">
                    <label for="start_date" class="form-label">Date personnalisée :</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4" id="specificDate" style="display: none;">
                    <label for="month" class="form-label">Mois :</label>
                    <select name="month" id="month" class="form-select">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                        @endforeach
                    </select>
                    <label for="year" class="form-label">Année :</label>
                    <select name="year" id="year" class="form-select">
                        @foreach(range(date('Y') - 5, date('Y')) as $y)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Générer le rapport</button>
                </div>
            </div>
        </form>

        <script>
            function toggleDateSelection() {
                let period = document.getElementById('period').value;
                document.getElementById('customDate').style.display = period === 'custom' ? 'block' : 'none';
                document.getElementById('specificDate').style.display = period === 'specific' ? 'block' : 'none';
            }
            document.addEventListener('DOMContentLoaded', toggleDateSelection);

        </script>


        <!-- Boutons pour exporter les rapports -->
        <div class="mb-4">
            <a href="{{ route('report.export', ['format' => 'pdf', 'month' => $selectedMonth, 'year' => $selectedYear]) }}" class="btn btn-danger me-2">Exporter en PDF</a>
            <a href="{{ route('report.export', ['format' => 'excel', 'month' => $selectedMonth, 'year' => $selectedYear]) }}" class="btn btn-success">Exporter en Excel</a>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total des Projets</h5>
                        <p class="card-text h3">{{ $totalProjects }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Projets Terminés</h5>
                        <p class="card-text h3">{{ $completedProjects }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Projets En Cours</h5>
                        <p class="card-text h3">{{ $ongoingProjects }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section des statistiques globales -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
            <div class="card-header bg-success text-white">Statistiques Globales</div>
            <div class="card-body">
                <p><strong>Budget total :</strong> {{ number_format($totalBudget) }} FCFA</p>
                <p><strong>Secteur :</strong> {{ $sectorCount }}</p>
                <p><strong>Répartition par statut :</strong></p>
                <canvas id="statusChart" ></canvas>
            </div>
        </div>
            </div>


        <!-- Section des projets par coach -->
                <div class="col-md-6">
                    <div class="card">
            <div class="card-header bg-info text-white">Projets par Coach</div>
            <div class="card-body">
                <ul>
                    @foreach($projectsByCoach as $coachId => $data)
                        <li>{{ $data['coach_name'] }} : {{ $data['total_projects'] }} projets</li>
                    @endforeach
                </ul>
                <canvas id="coachChart" width="400" height="200"></canvas>
            </div>
        </div>
                </div>
    </div>

        <!-- Section du rapport mensuel -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Projets par secteur</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="projectsBySectorChart"></canvas>
                    </div>
                </div>
            </div>




        <!-- Section des projets par mois -->
                <div class="col-md-6">
                    <div class="card">
            <div class="card-header bg-primary text-white">Projets Créés par Mois</div>
            <div class="card-body">
                <canvas id="projectsByMonthChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
        </div>




    <!-- Graphiques -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-white">Rapport Mensuel ({{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }})</div>
                <div class="card-body">
                    <p><strong>Projets créés :</strong> {{ $monthlyProjects->count() }}</p>
                    <p><strong>Tâches terminées :</strong> {{ $tasksCompleted }}</p>
                    <p><strong>Tâches en cours :</strong> {{ $tasksInProgress }}</p>
                    <p><strong>Tâches en retard :</strong> {{ $overdueTasks }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-danger text-white">Tâches en Retard</div>
                <div class="card-body">
                    <h5 class="text-danger">{{ $overdueTasks }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Évolution des projets</h5>
                </div>
                <div class="card-body">
                    <canvas id="projectsOverTimeChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- Statistiques détaillées -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Performance des tâches</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Total des tâches</th>
                            <td>{{ $taskStats['total'] }}</td>
                        </tr>
                        <tr>
                            <th>Taux de complétion</th>
                            <td>{{ number_format($taskStats['completion_rate'], 1) }}%</td>
                        </tr>
                        <tr>
                            <th>Temps moyen de complétion</th>
                            <td>{{ number_format($taskStats['average_completion_time'], 1) }} jours</td>
                        </tr>
                        <tr>
                            <th>Total des Tâches en retard</th>
                            <td>{{ $taskStats['overdue'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Sessions de mentorat</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Total des sessions</th>
                            <td>{{ $mentorshipStats['total'] }}</td>
                        </tr>
                        <tr>
                            <th>Durée moyenne</th>
                            <td>{{ number_format($mentorshipStats['average_duration'], 0) }} minutes</td>
                        </tr>
                        <tr>
                            <th>Sessions par coach (moyenne)</th>
                            <td>{{ $mentorshipStats['by_coach']->avg('total') ?? 0 }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Données pour le graphique des statuts
        const statusData = {
            labels: @json(array_keys($statusCount->toArray())),
            datasets: [{
                label: 'Nombre de Projets',
                data: @json(array_values($statusCount->toArray())),
                backgroundColor: ['#4caf50', '#ff9800', '#f44336', '#2196f3'],
            }]
        };

        // Données pour le graphique des projets par coach
        const coachLabels = @json($projectsByCoach->pluck('coach_name')->values()->toArray());
        const coachData = @json($projectsByCoach->pluck('total_projects')->values()->toArray());

        const coachChartData = {
            labels: coachLabels,
            datasets: [{
                label: 'Projets par Coach',
                data: coachData,
                backgroundColor: '#42a5f5',
            }]
        };

        // Données pour le graphique des projets par mois
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

        // Configuration du graphique
        new Chart(document.getElementById('statusChart'), {
            type: 'pie',
            data: statusData,
            options: {
                responsive: true,  // Permet d'ajuster la taille
                maintainAspectRatio: false, // Empêche la contrainte de ratio pour mieux contrôler la hauteur
                plugins: {
                    legend: {
                        position: 'bottom', // Place la légende en bas pour gagner de l'espace
                    }
                }
            }
        });

        new Chart(document.getElementById('coachChart'), {
            type: 'bar',
            data: coachChartData,
        });

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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Graphique des projets par secteur
            new Chart(document.getElementById('projectsBySectorChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode($projectStats['by_sector']->pluck('sector')) !!},
                    datasets: [{
                        data: {!! json_encode($projectStats['by_sector']->pluck('total')) !!},
                        backgroundColor: ['#27ae60', '#2ecc71', '#16a085', '#1abc9c', '#2980b9']
                    }]
                }
            });

            // Graphique de l'évolution des projets
            new Chart(document.getElementById('projectsOverTimeChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($projectStats['over_time']->pluck('date')) !!},
                    datasets: [{
                        label: 'Nombre de projets',
                        data: {!! json_encode($projectStats['over_time']->pluck('total')) !!},
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
        });
    </script>
@endsection
