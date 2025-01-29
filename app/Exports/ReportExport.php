<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class ReportExport implements FromArray
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        // En-tête du tableau
        $header = [
            'Titre', 'Statut', 'Budget', 'Coach', 'Total Projets', 'Projets Terminés', 'Projets En Cours', 'Projets à Venir', 'Budget Total',
            'Secteur', 'Projets par Coach', 'Total des Tâches', 'Tâches Soumises', 'Tâches en Retard', 'Total des Séances de Mentorat', 'Sessions Ce Mois-ci'
        ];

        // Contenu des projets
        $projects = array_map(function ($project) {
            return [
                $project['title'],
                ucfirst($project['status']),
                number_format($project['budget']),
                $project['coach']['name'] ?? 'Non assigné',
                $this->data['totalProjects'],
                $this->data['completedProjects'],
                $this->data['ongoingProjects'],
                $this->data['upcomingProjects'],
                number_format($this->data['totalBudget']),
                $project['sector'],
                $this->getProjectsByCoach($project),
                $this->data['totalTasks'],
                $this->data['completedTasks'],
                $this->data['overdueTasks'],
                $this->data['totalMentorshipSessions'],
                $this->data['sessionsThisMonth']
            ];
        }, $this->data['projects']->toArray());

        // Combine l'en-tête et les projets
        return array_merge([$header], $projects);
    }

    // Fonction pour récupérer les projets par coach (renvoie un format adapté à l'export)
    private function getProjectsByCoach($project)
    {
        $coachId = $project['coach_id'];
        $coachData = $this->data['projectsByCoach'][$coachId] ?? null;

        return $coachData ? "{$coachData['coach_name']} : {$coachData['total_projects']} projets" : 'Non assigné';
    }
}
