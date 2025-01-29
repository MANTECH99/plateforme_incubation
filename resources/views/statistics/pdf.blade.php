<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport Statistique</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }
        h1, h2, h3 {
            color: #27ae60;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        .summary-table th, .summary-table td {
            border: none;
            text-align: left;
        }
        .summary-table {
            margin: 20px 0;
        }
        .summary-table td {
            padding: 5px 10px;
        }
        .chart {
            margin-top: 30px;
            text-align: center;
        }
        footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>
<h1>Rapport Statistique</h1>
<h3>{{ now()->format('d M Y') }}</h3>

<table class="summary-table">
    <tr>
        <td><strong>Total des Projets :</strong></td>
        <td>{{ $totalProjects }}</td>
    </tr>
    <tr>
        <td><strong>Projets Terminés :</strong></td>
        <td>{{ $completedProjects }}</td>
    </tr>
    <tr>
        <td><strong>Projets en Cours :</strong></td>
        <td>{{ $ongoingProjects }}</td>
    </tr>
    <tr>
        <td><strong>Projets à Venir :</strong></td>
        <td>{{ $upcomingProjects }}</td>
    </tr>
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
    <tr>
        <td><strong>Total des Séances de Mentorat :</strong></td>
        <td>{{ $totalMentorshipSessions }}</td>
    </tr>
    <tr>
        <td><strong>Sessions Ce Mois-ci :</strong></td>
        <td>{{ $sessionsThisMonth }}</td>
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
@if ($projectDetails->isNotEmpty())
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
        </tr>
        </thead>
        <tbody>
        @foreach ($projectDetails as $project)
            <tr>
                <td>{{ $project->title }}</td>
                <td>{{ $project->sector }}</td>
                <td>{{ number_format($project->budget, 2) }} €</td>
                <td>{{ ucfirst($project->status) }}</td>
                <td>{{ $project->created_at->format('d/m/Y') }}</td>
                <td>{{ $project->tasks_count }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>Aucun détail de projet disponible.</p>
@endif


<footer>
    Généré automatiquement le {{ now()->format('d/m/Y à H:i:s') }}
</footer>
</body>
</html>
