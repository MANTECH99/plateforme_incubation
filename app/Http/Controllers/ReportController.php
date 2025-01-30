<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\MentorshipSession;
use App\Models\Project;
use App\Models\Task;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
// Méthode pour générer un rapport complet
    public function generateReport(Request $request)
    {
        $period = $request->input('period', 'month');
        // Déterminer la date de début en fonction de la période sélectionnée
        $month = $request->input('month', now()->format('m'));
        $year = $request->input('year', now()->format('Y'));
        // Gestion des périodes
        if ($period === 'year') {
            $startDate = Carbon::createFromDate($year, 1, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, 12, 31)->endOfDay();
        } elseif ($period === 'month') {
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay(); // Assurez-vous que l'heure de fin est à la fin du mois
        } elseif ($period === 'specific') {
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay();
        } elseif ($period === 'quarter') {
            $quarter = ceil($month / 3);
            $startMonth = ($quarter - 1) * 3 + 1;
            $endMonth = $startMonth + 2;

            $startDate = Carbon::createFromDate($year, $startMonth, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, $endMonth, 1)->endOfMonth()->endOfDay(); // Fin du trimestre
        } elseif ($period === 'week') {
            // Calculer le début et la fin de la semaine en fonction de la date actuelle
            $startDate = Carbon::now()->startOfWeek()->startOfDay(); // Lundi de cette semaine
            $endDate = Carbon::now()->endOfWeek()->endOfDay(); // Dimanche de cette semaine
        }else {
            // Pour une période personnalisée
            $startDate = $this->getStartDate($period);
            $endDate = now();
        }

// Ajouter un log avant d'exécuter la requête pour vérifier les dates
        Log::info('Période sélectionnée pour les sessions de mentoratss', [
            'start_date' => $startDate->toDateTimeString(),
            'end_date' => $endDate->toDateTimeString(),
        ]);



        // Filtrer les projets en fonction de la période
        $projects = Project::with(['user', 'coach', 'tasks'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Statistiques globales
        $totalProjects = $projects->count();
        $completedProjects = $projects->where('status', 'terminé')->count();
        $ongoingProjects = $projects->where('status', 'en cours')->count();
        $upcomingProjects = $projects->where('status', 'à venir')->count();
        $totalBudget = $projects->sum('budget');
        $sectorCount = $projects->groupBy('sector')->map->count();
        $statusCount = $projects->groupBy('status')->map->count();

        // Statistiques des tâches
        $totalTasks = Task::whereBetween('created_at', [$startDate, $endDate])->count();
        $completedTasks = Task::whereBetween('created_at', [$startDate, $endDate])->where('status', 'soumis')->count();
        $tasksCompleted = Task::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'soumis')
            ->count();

        $tasksInProgress = Task::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'en cours')
            ->count();

        $overdueTasks = Task::where('due_date', '<', now())
            ->where('status', '!=', 'soumis')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();


        // Projets par coach
        $projectsByCoach = $projects->groupBy('coach_id')->map(function ($projects, $coachId) {
            return [
                'coach_name' => optional($projects->first()->coach)->name ?? 'Non assigné',
                'total_projects' => $projects->count(),
                'status_count' => $projects->groupBy('status')->map->count(),
            ];
        });

        // Rapports mensuels pour "Mois/Année spécifique"
        $monthlyProjects = $projects->filter(function ($project) use ($month, $year) {
            return Carbon::parse($project->created_at)->month == $month &&
                Carbon::parse($project->created_at)->year == $year;
        });



        // Statistiques des projets, tâches et mentorat selon la période
        $projectStats = $this->getProjectStats($startDate);
        $taskStats = $this->getTaskStats($startDate, $endDate);



        $mentorshipStats = $this->getMentorshipStats($startDate, $endDate);

        $additionalStats = $this->getAdditionalStats($startDate);
        $selectedMonth = $month ?? now()->format('m');
        $selectedYear = $year ?? now()->format('Y');

        $monthlyProjectsStats = Project::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                $item->month_name = date('F', mktime(0, 0, 0, $item->month, 1));
                return $item;
            });



        return view('reports.index', [
            'totalProjects' => $totalProjects,
            'completedProjects' => $completedProjects,
            'ongoingProjects' => $ongoingProjects,
            'upcomingProjects' => $upcomingProjects,
            'totalBudget' => $totalBudget,
            'sectorCount' => $sectorCount,
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'overdueTasks' => $overdueTasks,
            'projectsByCoach' => $projectsByCoach,
            'monthlyProjects' => $monthlyProjects,
            'tasksCompleted' => $tasksCompleted,
            'tasksInProgress' => $tasksInProgress,
            'statusCount' => $statusCount,
            'projectStats' => $projectStats,
            'taskStats' => $taskStats,
            'mentorshipStats' => $mentorshipStats,
            'additionalStats' => $additionalStats,
            'period' => $period,
            'month' => $month,
            'year' => $year,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'monthlyProjectsStats' => $monthlyProjectsStats, // ✅ Ajout ici
            'startDate' => $startDate,
            'endDate' => $endDate,

        ]);
    }




    private function getStartDate($period)
    {
        return match($period) {
            'week' => now()->subWeek(),
            'month' => now()->subMonth(),
            'quarter' => now()->subQuarter(),
            'year' => now()->subYear(),
            'custom' => request('start_date') ? Carbon::parse(request('start_date')) : now()->subMonth(),
            default => now()->subMonth(),
        };
    }

    private function getProjectStats($startDate)
    {
        $totalProjects = Project::where('created_at', '>=', $startDate)->count();

        $projectsBySector = Project::where('created_at', '>=', $startDate)
            ->select('sector', DB::raw('count(*) as total'))
            ->groupBy('sector')
            ->get();

        $projectsByStatus = Project::where('created_at', '>=', $startDate)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $averageBudget = Project::where('created_at', '>=', $startDate)
            ->avg('budget');

        $projectsOverTime = Project::where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $projectsByCoach = Project::where('created_at', '>=', $startDate)
            ->whereNotNull('coach_id')
            ->with('coach')
            ->select('coach_id', DB::raw('count(*) as total'))
            ->groupBy('coach_id')
            ->get();

        return [
            'total' => $totalProjects,
            'by_sector' => $projectsBySector,
            'by_status' => $projectsByStatus,
            'average_budget' => $averageBudget,
            'over_time' => $projectsOverTime,
            'by_coach' => $projectsByCoach
        ];
    }

    private function getTaskStats($startDate, $endDate)
    {

        $totalTasks = Task::whereBetween('created_at', [$startDate, $endDate])->count();

        $tasksByStatus = Task::whereBetween('created_at', [$startDate, $endDate])
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $completionRate = Task::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['soumis', 'terminé'])
                ->count() / ($totalTasks ?: 1) * 100;

        $averageCompletionTime = Task::whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('due_date')
            ->select(DB::raw('AVG(DATEDIFF(due_date, created_at)) as avg_days'))
            ->first()
            ->avg_days ?? 0; // Évite d'afficher NULL

        // 🔥 Correction ici : Filtrer les tâches en retard **uniquement pour la période sélectionnée**
        $tasksOverdue = Task::whereBetween('created_at', [$startDate, $endDate]) // ✅ Respecte la période choisie
        ->whereBetween('due_date', [$startDate, $endDate]) // ✅ Filtrer les tâches avec due_date <= endDate
        ->where('status', '!=', 'soumis')
            ->count();

        return [
            'total' => $totalTasks,
            'by_status' => $tasksByStatus,
            'completion_rate' => $completionRate,
            'average_completion_time' => $averageCompletionTime,
            'overdue' => $tasksOverdue
        ];
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



    private function getAdditionalStats($startDate)
    {
        $activeProjects = Project::where('status', 'en cours')->count();
        $completedProjects = Project::where('status', 'terminé')->count();

        $topSectors = Project::select('sector', DB::raw('count(*) as total'))
            ->groupBy('sector')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $averageTasksPerProject = Project::withCount('tasks')
            ->get()
            ->avg('tasks_count');

        return [
            'active_projects' => $activeProjects,
            'completed_projects' => $completedProjects,
            'top_sectors' => $topSectors,
            'average_tasks_per_project' => $averageTasksPerProject
        ];
    }

    // Méthode pour exporter le rapport
    public function export(Request $request)
    {



        $format = $request->input('format');

        $period = $request->input('period', 'month');
        // Déterminer la date de début en fonction de la période sélectionnée
        $month = $request->input('month', now()->format('m'));
        $year = $request->input('year', now()->format('Y'));
        // Gestion des périodes
        if ($period === 'year') {
            $startDate = Carbon::createFromDate($year, 1, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, 12, 31)->endOfDay();
        } elseif ($period === 'month') {
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay(); // Assurez-vous que l'heure de fin est à la fin du mois
        } elseif ($period === 'specific') {
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay();
        } elseif ($period === 'quarter') {
            $quarter = ceil($month / 3);
            $startMonth = ($quarter - 1) * 3 + 1;
            $endMonth = $startMonth + 2;

            $startDate = Carbon::createFromDate($year, $startMonth, 1)->startOfDay();
            $endDate = Carbon::createFromDate($year, $endMonth, 1)->endOfMonth()->endOfDay(); // Fin du trimestre
        } elseif ($period === 'week') {
            // Calculer le début et la fin de la semaine en fonction de la date actuelle
            $startDate = Carbon::now()->startOfWeek()->startOfDay(); // Lundi de cette semaine
            $endDate = Carbon::now()->endOfWeek()->endOfDay(); // Dimanche de cette semaine
        }else {
            // Pour une période personnalisée
            $startDate = $this->getStartDate($period);
            $endDate = now();
        }
// Ajouter un log avant d'exécuter la requête pour vérifier les dates
        Log::info('Période sélectionnée pour les sessions de mentorat', [
            'start_date' => $startDate->toDateTimeString(),
            'end_date' => $endDate->toDateTimeString(),
        ]);

        // Collecte des données pour l'exportation
        $projects = Project::with(['user', 'coach'])->withCount('tasks')->get();

        $totalProjects = $projects->count();
        $completedProjects = $projects->where('status', 'terminé')->count();
        $ongoingProjects = $projects->where('status', 'en cours')->count();
        $upcomingProjects = $projects->where('status', 'à venir')->count();
        $totalBudget = $projects->sum('budget');
        $sectorCount = $projects->groupBy('sector')->count();
        $projectsByCoach = $projects->groupBy('coach_id')->map(function ($items, $coachId) {
            return [
                'coach_name' => $items->first()->coach->name ?? 'Non assigné',
                'total_projects' => $items->count()
            ];
        });

        // Récupérer les tâches
        $tasks = Task::all();
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', 'soumis')->count();
        $overdueTasks = $tasks->where('due_date', '<', now())->where('status', '!=', 'soumis')->count();

        // Récupérer les sessions de mentorat
        $mentorSessions = MentorshipSession::all();
        $totalMentorshipSessions = $mentorSessions->count();









        $data = [
            'taskStats' => $this->getTaskStats($startDate, $endDate),
            'mentorshipStats' => $this->getMentorshipStats($startDate, $endDate),
            'month' => $month,
            'year' => $year,
            'projects' => $projects,
            'totalProjects' => $totalProjects,
            'completedProjects' => $completedProjects,
            'ongoingProjects' => $ongoingProjects,
            'upcomingProjects' => $upcomingProjects,
            'totalBudget' => $totalBudget,
            'sectorCount' => $sectorCount,
            'projectsByCoach' => $projectsByCoach,
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'overdueTasks' => $overdueTasks,
            'totalMentorshipSessions' => $totalMentorshipSessions,
            // Ajouter les détails des projets
            'projectDetails' => Project::select('title', 'sector', 'budget', 'status', 'created_at')
                ->withCount('tasks')
                ->get(),
            'monthlyProjects' => Project::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
        ];

        if ($format === 'pdf') {
            $pdf = PDF::loadView('reports.export_pdf', $data);
            return $pdf->download('rapport_' . $month . '_' . $year . '.pdf');
        } elseif ($format === 'excel') {
            return Excel::download(new ReportExport($data), 'rapport_' . $month . '_' . $year . '.xlsx');
        } else {
            return redirect()->back()->with('error', 'Format non pris en charge.');
        }
    }


}
