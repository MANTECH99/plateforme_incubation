<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #27ae60;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
<h1>Rapport Statistique</h1>

<p><strong>Mois :</strong> {{ $month }}</p>
<p><strong>Année :</strong> {{ $year }}</p>

<h2>Statistiques Globales</h2>
<p><strong>Total des projets :</strong> {{ $totalProjects }}</p>
<p><strong>Projets Terminés :</strong> {{ $completedProjects }}</p>
<p><strong>Projets En Cours :</strong> {{ $ongoingProjects }}</p>
<p><strong>Projets à Venir :</strong> {{ $upcomingProjects }}</p>
<p><strong>Budget total :</strong> {{ number_format($totalBudget) }} FCFA</p>
<p><strong>Secteur :</strong> {{ $sectorCount }}</p>

<h2>Détails des Projets</h2>
<table>
    <thead>
    <tr>
        <th>Titre</th>
        <th>Secteur</th>
        <th>Budget</th>
        <th>Statut</th>
        <th>Date de Création</th>
        <th>Nombre de Tâches</th>
        <th>coach</th>
    </tr>
    </thead>
    <tbody>
    @foreach($projects as $project)
        <tr>
            <td>{{ $project->title }}</td>
            <td>{{ $project->sector }}</td>
            <td>{{ number_format($project->budget, 2) }} €</td>
            <td>{{ ucfirst($project->status) }}</td>
            <td>{{ $project->created_at->format('d/m/Y') }}</td>
            <td>{{ $project->tasks_count }}</td>
            <td>{{ $project->coach->name ?? 'Non assigné' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h2>Projets par Coach</h2>
<ul>
    @foreach($projectsByCoach as $coach)
        <li>{{ $coach['coach_name'] }} : {{ $coach['total_projects'] }} projets</li>
    @endforeach
</ul>

<h2>Tâches</h2>
<table>
    <tr>
        <td><strong>Total des Tâches :</strong></td>
        <td>{{ $totalTasks }}</td>
    </tr>
    <tr>
        <td><strong>Tâches Soumises :</strong></td>
        <td>{{ $completedTasks }}</td>
    </tr>
    <tr>
        <td><strong>Tâches en Retard :</strong></td>
        <td>{{ $overdueTasks }}</td>
    </tr>
</table>

<h2>Sessions de Mentorat</h2>
<table>
    <tr>
        <td><strong>Total des Séances de Mentorat :</strong></td>
        <td>{{ $totalMentorshipSessions }}</td>
    </tr>
    <tr>
        <td><strong>Sessions Ce Mois-ci :</strong></td>
        <td>{{ $mentorshipStats['total'] }}</td>
    </tr>
    <tr>
    <th>Durée moyenne</th>
    <td>{{ number_format($mentorshipStats['average_duration'], 0) }} minutes</td>
    </tr>
</table>
<h2>Répartition Mensuelle des Projets</h2>
<table>
    <thead>
    <tr>
        <th>Mois</th>
        <th>Nombre de Projets</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($monthlyProjects as $stat)
        <tr>
            <td>{{ DateTime::createFromFormat('!m', $stat->month)->format('F') }}</td>
            <td>{{ $stat->count }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h2>Performance des Tâches</h2>
<table>
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
</table>
<!-- Statistiques Globales -->
<div class="card">
    <div class="card-header">
        <h2>Statistiques Globales</h2>
    </div>
    <div class="card-body">
        <p><strong>Budget total :</strong> {{ number_format($totalBudget) }} FCFA</p>
        <p><strong>Nombre de secteurs :</strong> {{ $sectorCount }}</p>
        <p><strong>Répartition par statut :</strong></p>
        <table>
            <thead>
            <tr>
                <th>Statut</th>
                <th>Nombre de Projets</th>
            </tr>
            </thead>
            <tbody>
            @foreach($statusCount as $status => $count)
                <tr>
                    <td>{{ $status }}</td>
                    <td>{{ $count }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Projets par Coach -->
<div class="card">
    <div class="card-header bg-info text-white">
        <h2>Projets par Coach</h2>
    </div>
    <div class="card-body">
        <table>
            <thead>
            <tr>
                <th>Coach</th>
                <th>Nombre de Projets</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projectsByCoach as $coachId => $data)
                <tr>
                    <td>{{ $data['coach_name'] }}</td>
                    <td>{{ $data['total_projects'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

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


<footer>
    Généré automatiquement le {{ now()->format('d/m/Y à H:i:s') }}
</footer>
</body>
</html>
