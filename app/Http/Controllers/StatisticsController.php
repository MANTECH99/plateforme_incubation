<?php

namespace App\Http\Controllers;

use App\Exports\StatisticsExport;
use App\Models\Project;
use App\Models\Task;
use App\Models\MentorshipSession;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class StatisticsController extends Controller
{
    public function index()
    {
        // Récupérer les données globales
        $totalProjects = Project::count();
        $completedProjects = Project::where('status', 'terminé')->count();
        $ongoingProjects = Project::where('status', 'en cours')->count();
        $upcomingProjects = Project::where('status', 'à venir')->count();

        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'soumis')->count();
        $overdueTasks = Task::where('due_date', '<', now())->where('status', '!=', 'soumis')->count();

        $totalMentorshipSessions = MentorshipSession::count();
        $sessionsThisMonth = MentorshipSession::whereMonth('start_time', Carbon::now()->month)->count();

        // Statistiques par mois pour les projets
        $monthlyProjects = Project::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Passer les données à la vue
        return view('statistics.index', compact(
            'totalProjects',
            'completedProjects',
            'ongoingProjects',
            'upcomingProjects',
            'totalTasks',
            'completedTasks',
            'overdueTasks',
            'totalMentorshipSessions',
            'sessionsThisMonth',
            'monthlyProjects'
        ));
    }



    public function exportPDF()
    {
        // Augmenter la limite de mémoire pour cette opération
        ini_set('memory_limit', '256M');
        $data = [
            'totalProjects' => Project::count(),
            'completedProjects' => Project::where('status', 'terminé')->count(),
            'ongoingProjects' => Project::where('status', 'en cours')->count(),
            'upcomingProjects' => Project::where('status', 'à venir')->count(),
            'totalTasks' => Task::count(),
            'completedTasks' => Task::where('status', 'soumis')->count(),
            'overdueTasks' => Task::where('due_date', '<', now())->where('status', '!=', 'soumis')->count(),
            'totalMentorshipSessions' => MentorshipSession::count(),
            'sessionsThisMonth' => MentorshipSession::whereMonth('start_time', Carbon::now()->month)->count(),
            'monthlyProjects' => Project::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
            // Ajouter les détails des projets
            'projectDetails' => Project::select('title', 'sector', 'budget', 'status', 'created_at')
                ->withCount('tasks')
                ->get(),
        ];

        $pdf = PDF::loadView('statistics.pdf', $data);

        return $pdf->download('rapport-statistiques.pdf');
    }

    public function exportExcel()
    {
        // Augmenter la limite de mémoire pour cette opération
        ini_set('memory_limit', '256M');
        // Récupérer les données pour Excel
        return Excel::download(new StatisticsExport, 'rapport-statistiques.xlsx');
    }
}
