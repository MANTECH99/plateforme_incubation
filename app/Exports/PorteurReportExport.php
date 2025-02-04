<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PorteurReportExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $rows = [];

        // Ajouter les statistiques globales
        $rows[] = ['Statistique', 'Valeur'];
        $rows[] = ['Total des projets', $this->data['totalProjects']];
        $rows[] = ['Projets terminés', $this->data['completedProjects']];
        $rows[] = ['Projets en cours', $this->data['ongoingProjects']];
        $rows[] = ['Projets à venir', $this->data['upcomingProjects']];
        $rows[] = ['Budget total', $this->data['totalBudget']];
        $rows[] = ['Total des tâches', $this->data['totalTasks']];
        $rows[] = ['Tâches terminées', $this->data['completedTasks']];
        $rows[] = ['Tâches en retard', $this->data['overdueTasks']];
        $rows[] = ['Sessions de mentorat', $this->data['totalMentorshipSessions']];

        // Ajouter les projets
        $rows[] = [];
        $rows[] = ['Projets'];
        $rows[] = ['Titre', 'Statut', 'Budget', 'Tâches'];
        foreach ($this->data['projects'] as $project) {
            $rows[] = [
                $project->title,
                $project->status,
                $project->budget,
                $project->tasks->count(),
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [];
    }
}
