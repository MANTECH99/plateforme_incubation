<?php

namespace App\Exports;

use App\Models\MentorshipSession;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;

class ReportExport implements FromArray
{
    protected $data;
    protected $startDate;
    protected $endDate;

    public function __construct(array $data, $startDate, $endDate)
    {
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        // Ajouter les stats de mentorat
        $this->data['mentorshipStats'] = $this->getMentorshipStats($startDate, $endDate);

        // Ajouter 'totalSessions' pour l'export
        $this->data['totalSessions'] = $this->data['mentorshipStats']['total'];
    }

    private function getMentorshipStats($startDate, $endDate)
    {


        $totalSessions = MentorshipSession::whereBetween('start_time', [$startDate, $endDate])->count();

        $sessionsByMonth = MentorshipSession::whereBetween('start_time', [$startDate, $endDate])
            ->select(DB::raw('MONTH(start_time) as month'), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $averageDuration = MentorshipSession::whereBetween('start_time', [$startDate, $endDate])
            ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, start_time, end_time)) as avg_duration'))
            ->first()
            ->avg_duration;

        $sessionsByCoach = MentorshipSession::whereBetween('start_time', [$startDate, $endDate])
            ->with('coach')
            ->select('coach_id', DB::raw('count(*) as total'))
            ->groupBy('coach_id')
            ->get();

        return [
            'total' => $totalSessions,
            'by_month' => $sessionsByMonth,
            'average_duration' => $averageDuration,
            'by_coach' => $sessionsByCoach
        ];
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
                $this->data['totalSessions']
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
