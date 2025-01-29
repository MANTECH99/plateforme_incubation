<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\MentorshipSession;
use App\Models\Project;
use App\Models\Task;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    // Méthode pour générer un rapport complet
// Méthode pour générer un rapport complet
    public function generateReport(Request $request)
    {
        $month = $request->input('month', now()->format('m')); // Mois sélectionné (par défaut le mois en cours)
        $year = $request->input('year', now()->format('Y'));   // Année sélectionnée (par défaut l'année en cours)

        // Récupérer tous les projets
        $projects = Project::with(['user', 'coach', 'tasks'])->get();

        // Statistiques globales
        $totalProjects = $projects->count();
        $completedProjects = Project::where('status', 'terminé')->count();
        $ongoingProjects = Project::where('status', 'en cours')->count();
        $upcomingProjects = Project::where('status', 'à venir')->count();
        $totalBudget = $projects->sum('budget');
        $sectorCount = $projects->groupBy('sector')->map->count();

        // Statistiques des tâches
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'soumis')->count();
        $overdueTasks = Task::where('due_date', '<', now())->where('status', '!=', 'soumis')->count();
        $statusCount = $projects->groupBy('status')->map->count();


        // Statistiques des sessions de mentorat
        $totalMentorshipSessions = MentorshipSession::count();
        $sessionsThisMonth = MentorshipSession::whereMonth('start_time', Carbon::now()->month)->count();

        // Statistiques par mois pour les projets
        $monthlyProjectsStats = Project::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                $item->month_name = date('F', mktime(0, 0, 0, $item->month, 1));
                return $item;
            });


        // Projets par coach
        $projectsByCoach = $projects->groupBy('coach_id')->map(function ($projects, $coachId) {
            return [
                'coach_name' => optional($projects->first()->coach)->name ?? 'Non assigné',
                'total_projects' => $projects->count(),
                'status_count' => $projects->groupBy('status')->map->count(),
            ];
        });

        // Rapports mensuels
        $monthlyProjects = $projects->filter(function ($project) use ($month, $year) {
            return Carbon::parse($project->created_at)->month == $month &&
                Carbon::parse($project->created_at)->year == $year;
        });

        $tasksCompleted = $monthlyProjects->flatMap->tasks->where('status', 'soumis')->count();
        $tasksInProgress = $monthlyProjects->flatMap->tasks->where('status', 'en cours')->count();

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
            'totalMentorshipSessions' => $totalMentorshipSessions,
            'sessionsThisMonth' => $sessionsThisMonth,
            'monthlyProjectsStats' => $monthlyProjectsStats,
            'projectsByCoach' => $projectsByCoach,
            'monthlyProjects' => $monthlyProjects,
            'tasksCompleted' => $tasksCompleted,
            'tasksInProgress' => $tasksInProgress,
            'selectedMonth' => $month,
            'selectedYear' => $year,
            'statusCount' => $statusCount,
        ]);
    }

    // Méthode pour exporter le rapport
    public function export(Request $request)
    {
        $format = $request->input('format');
        $month = $request->input('month', now()->format('m'));
        $year = $request->input('year', now()->format('Y'));

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
        $sessionsThisMonth = MentorshipSession::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->count();


        $data = [
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
            'sessionsThisMonth' => $sessionsThisMonth,
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
