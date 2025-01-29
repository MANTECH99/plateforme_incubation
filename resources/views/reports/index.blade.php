@extends('layouts.app')

@section('title', 'Rapport Statistique')

@section('content')
    <div class="container" style="width: 100%; margin: 0; padding: 0;">
        <h1 class="mb-4 text-center">Rapport Statistique</h1>

        <!-- Filtres de sélection pour le mois et l'année -->
        <form method="GET" action="{{ route('report.generate') }}" class="mb-4">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label for="month" class="form-label">Mois :</label>
                    <select name="month" id="month" class="form-select">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $m == $selectedMonth ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="year" class="form-label">Année :</label>
                    <select name="year" id="year" class="form-select">
                        @foreach(range(date('Y') - 5, date('Y')) as $y)
                            <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Générer le rapport</button>
                </div>
            </div>
        </form>

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
        <div class="card mb-4">
            <div class="card-header bg-success text-white">Statistiques Globales</div>
            <div class="card-body">
                <p><strong>Budget total :</strong> {{ number_format($totalBudget) }} FCFA</p>
                <p><strong>Secteur :</strong> {{ $sectorCount }}</p>
                <p><strong>Répartition par statut :</strong></p>
                <canvas id="statusChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Section des projets par coach -->
        <div class="card mb-4">
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

        <!-- Section du rapport mensuel -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-white">Rapport Mensuel ({{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }})</div>
            <div class="card-body">
                <p><strong>Projets créés :</strong> {{ $monthlyProjects->count() }}</p>
                <p><strong>Tâches terminées :</strong> {{ $tasksCompleted }}</p>
                <p><strong>Tâches en cours :</strong> {{ $tasksInProgress }}</p>
                <p><strong>Tâches en retard :</strong> {{ $overdueTasks }}</p>
            </div>
        </div>

        <!-- Section des projets par mois -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Projets Créés par Mois</div>
            <div class="card-body">
                <canvas id="projectsByMonthChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-danger text-white">Tâches en Retard</div>
        <div class="card-body">
            <h5 class="text-danger">{{ $overdueTasks }}</h5>
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

        // Initialisation des graphiques
        new Chart(document.getElementById('statusChart'), {
            type: 'pie',
            data: statusData,
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
@endsection
