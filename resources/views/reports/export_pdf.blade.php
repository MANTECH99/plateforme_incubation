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
        footer {
            margin-top: 40px;
            font-size: 0.9em;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
<h1>Rapport Statistique</h1>

<p>Ce rapport présente une analyse détaillée des projets et des activités pour le mois de <strong>{{ $month }}</strong> de l'année <strong>{{ $year }}</strong>. Il offre un aperçu global des performances, des réalisations et des défis rencontrés au cours de cette période.</p>

<h2>Statistiques Globales</h2>
<p>Au cours de cette période, un total de <strong>{{ $totalProjects }}</strong> projets ont été recensés. Parmi ceux-ci, <strong>{{ $completedProjects }}</strong> ont été achevés avec succès, tandis que <strong>{{ $ongoingProjects }}</strong> sont encore en cours de réalisation. En outre, <strong>{{ $upcomingProjects }}</strong> projets sont prévus pour les prochains mois. Le budget total alloué à ces projets s'élève à <strong>{{ number_format($totalBudget) }} FCFA</strong>, répartis sur <strong>{{ $sectorCount }}</strong> secteurs d'activité.</p>

<h2>Détails des Projets</h2>
<p>Les projets enregistrés couvrent une variété de secteurs et présentent des statuts divers. Voici un aperçu des projets :</p>
<table>
    <thead>
    <tr>
        <th>Titre</th>
        <th>Secteur</th>
        <th>Budget</th>
        <th>Statut</th>
        <th>Date de Création</th>
        <th>Nombre de Tâches</th>
        <th>Coach</th>
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
<p>La répartition des projets entre les coaches montre une implication variée. Voici un résumé :</p>
<ul>
    @foreach($projectsByCoach as $coach)
        <li>{{ $coach['coach_name'] }} a supervisé <strong>{{ $coach['total_projects'] }}</strong> projets.</li>
    @endforeach
</ul>

<h2>Tâches</h2>
<p>En ce qui concerne les tâches, un total de <strong>{{ $totalTasks }}</strong> ont été enregistrées. Parmi celles-ci, <strong>{{ $completedTasks }}</strong> ont été soumises avec succès, tandis que <strong>{{ $overdueTasks }}</strong> sont en retard. Ces chiffres reflètent l'efficacité globale de la gestion des tâches.</p>

<h2>Sessions de Mentorat</h2>
<p>Les sessions de mentorat ont également été une partie importante des activités ce mois-ci. Un total de <strong>{{ $totalMentorshipSessions }}</strong> sessions ont été organisées, dont <strong>{{ $mentorshipStats['total'] }}</strong> ce mois-ci. La durée moyenne d'une session était de <strong>{{ number_format($mentorshipStats['average_duration'], 0) }} minutes</strong>.</p>

<h2>Répartition Mensuelle des Projets</h2>
<p>La répartition des projets par mois montre une évolution intéressante :</p>
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
<p>La performance des tâches est un indicateur clé de l'efficacité opérationnelle. Ce mois-ci, le taux de complétion des tâches était de <strong>{{ number_format($taskStats['completion_rate'], 1) }}%</strong>, avec un temps moyen de complétion de <strong>{{ number_format($taskStats['average_completion_time'], 1) }} jours</strong>.</p>

<h2>Statistiques Globales</h2>
<p>Le budget total alloué aux projets s'élève à <strong>{{ number_format($totalBudget) }} FCFA</strong>, répartis sur <strong>{{ $sectorCount }}</strong> secteurs. La répartition des projets par statut est la suivante :</p>
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

<h2>Projets par Secteur</h2>
<p>Les projets sont répartis dans différents secteurs d'activité. Voici un aperçu :</p>
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

<h2>Projets Créés par Mois</h2>
<p>Les projets sont répartis dans différents mois. Voici un aperçu :</p>
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




<h2>Évolution des Projets</h2>
<p>L'évolution des projets au fil du temps montre une dynamique intéressante :</p>
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

<footer>
    Ce rapport a été généré automatiquement le {{ now()->format('d/m/Y à H:i:s') }}.
</footer>
</body>
</html>