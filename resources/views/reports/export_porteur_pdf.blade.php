<!DOCTYPE html>
<html>
<head>
    <title>Rapport du Porteur de Projet - {{ $porteur->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #27ae60; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h1>Rapport pour {{ $porteur->name }}</h1>

<h2>Statistiques Globales</h2>
<ul>
    <li>Total des projets : {{ $totalProjects }}</li>
    <li>Projets terminés : {{ $completedProjects }}</li>
    <li>Projets en cours : {{ $ongoingProjects }}</li>
    <li>Projets à venir : {{ $upcomingProjects }}</li>
    <li>Budget total : {{ number_format($totalBudget) }} FCFA</li>
</ul>


<!-- Projets par Secteur -->
<div class="card">
    <div class="card-header">
        <h2>Projets par Secteur</h2>
    </div>
    <div class="card-body">
        <table>
            <thead>
            <tr>
                <th>Secteur</th>
                <th>Nombre de Projets</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projectStats['by_sector'] as $sector => $count)
                <tr>
                    <td>{{ $sector }}</td>
                    <td>{{ $count }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Projets par Mois -->
<div class="card">
    <div class="card-header bg-info text-white">
        <h2>Projets Créés par Mois</h2>
    </div>
    <div class="card-body">
        <table>
            <thead>
            <tr>
                <th>Mois</th>
                <th>Nombre de Projets</th>
            </tr>
            </thead>
            <tbody>
            @foreach($monthlyProjectsStats as $monthlyStat)
                <tr>
                    <td>{{ $monthlyStat->month_name }}</td>
                    <td>{{ $monthlyStat->count }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Rapport Mensuel -->
<div class="card">
    <div class="card-header">
        <h2>Rapport Mensuel ({{ date('F Y', mktime(0, 0, 0, (int) $selectedMonth, 1, (int) $selectedYear)) }})</h2>
    </div>
    <div class="card-body">
        <p><strong>Projets créés :</strong> {{ $monthlyProjects->count() }}</p>
        <p><strong>Tâches terminées :</strong> {{ $completedTasks }}</p>
        <p><strong>Tâches en cours :</strong> {{ $tasksInProgress }}</p>
        <p><strong>Tâches en retard :</strong> {{ $overdueTasks }}</p>
    </div>
</div>

<!-- Évolution des Projets -->
<div class="card">
    <div class="card-header bg-info text-white">
        <h2>Évolution des Projets</h2>
    </div>
    <div class="card-body">
        <table>
            <thead>
            <tr>
                <th>Date</th>
                <th>Nombre de Projets</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projectStats['over_time'] as $overTimeStat)
                <tr>
                    <td>{{ $overTimeStat->date }}</td>
                    <td>{{ $overTimeStat->total }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Tâches en Retard -->
<div class="card">
    <div class="card-header">
        <h2>Tâches en Retard</h2>
    </div>
    <div class="card-body">
        <h5 class="text-danger">{{ $overdueTasks }}</h5>
    </div>
</div>

<h2>Projets</h2>
<table>
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

<h2>Tâches</h2>
<ul>
    <li>Total des tâches : {{ $totalTasks }}</li>
    <li>Tâches terminées : {{ $completedTasks }}</li>
    <li>Tâches en retard : {{ $overdueTasks }}</li>
</ul>

<h2>Sessions de Mentorat</h2>
<ul>
    <li>Total des sessions : {{ $totalMentorshipSessions }}</li>
</ul>
</body>
</html>
