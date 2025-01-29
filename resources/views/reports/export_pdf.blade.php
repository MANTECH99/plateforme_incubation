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
<footer>
    Généré automatiquement le {{ now()->format('d/m/Y à H:i:s') }}
</footer>
</body>
</html>
