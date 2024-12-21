<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;


class DashboardController extends Controller
{
    public function coachDashboard(Request $request)
    {
        // Récupère l'utilisateur connecté
        $user = auth()->user();
    
        // Récupérer les porteuses de projet
        $porteuses = User::whereHas('role', function ($query) {
            $query->where('name', 'porteur de projet');
        })->get();
    
        // Si un porteur est sélectionné, récupérer ses projets
        $selectedPorteur = $request->get('porteuse_id') ? User::find($request->get('porteuse_id')) : null;
        $projects = $selectedPorteur ? $selectedPorteur->projects : collect();
    
        // Si un projet est sélectionné, récupérer les tâches associées
        $selectedProject = $request->get('project_id') ? Project::find($request->get('project_id')) : null;
        $tasks = $selectedProject ? $selectedProject->tasks : collect();
    
        // Calcul des statistiques des tâches du projet sélectionné
        $taskStats = [
            'en_attente' => $tasks->where('status', 'en attente')->count(),
            'soumis' => $tasks->where('status', 'soumis')->count(),
            'non_accompli' => $tasks->where('status', 'non accompli')->count(),
        ];
    
        return view('dashboard.coach', compact('porteuses', 'selectedPorteur', 'projects', 'selectedProject', 'taskStats'));
    }
    

    public function dashboardPorteur()
    {

                // Récupère l'utilisateur connecté
                $user = auth()->user();
                    // Récupérer le projet du porteur
    $projects = $user->projects; // Suppose que le porteur a une relation avec les projets

        // Calculer les statistiques des tâches
        $tasks = $user->projects->flatMap->tasks;

        $taskStats = [
            'en_attente' => $tasks->where('status', 'en attente')->count(),
            'soumis' => $tasks->where('status', 'soumis')->count(),
            'non_accompli' => $tasks->where('status', 'non accompli')->count(),
        ];
        $totalAdmins = User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->count();
    
        $totalPorteurs = User::whereHas('role', function ($query) {
            $query->where('name', 'porteur de projet');
        })->count();
    
        $totalCoachs = User::whereHas('role', function ($query) {
            $query->where('name', 'coach');
        })->count();

    
        return view('dashboard.porteur', compact('projects','totalAdmins', 'totalPorteurs', 'totalCoachs',
         'taskStats'));
    }
    

    
    public function dashboardAdmin(Request $request)
    {
        // Calcule le nombre total d'administrateurs
        $totalAdmins = User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->count();
    
        // Calcule le nombre total de porteurs de projets
        $totalPorteurs = User::whereHas('role', function ($query) {
            $query->where('name', 'porteur de projet');
        })->count();
    
        // Calcule le nombre total de coachs
        $totalCoachs = User::whereHas('role', function ($query) {
            $query->where('name', 'coach');
        })->count();
    
        // Récupérer les porteurs de projet pour la sélection
        $porteurs = User::whereHas('role', function ($query) {
            $query->where('name', 'porteur de projet');
        })->get();
    
        // Récupérer le porteur de projet sélectionné
        $selectedPorteur = null;
        $selectedPorteurProgress = collect();
    
        if ($request->has('porteur_id') && $request->porteur_id) {
            $selectedPorteur = User::find($request->porteur_id);
            
            // Récupérer la progression des projets pour ce porteur
            $selectedPorteurProgress = $selectedPorteur->projects->map(function ($project) {
                return [
                    'name' => $project->title,
                    'progress' => $project->tasks->avg('progress') // Calcul de la progression moyenne des tâches
                ];
            });
        }
    
        // Renvoyer les variables à la vue admin dashboard
        return view('dashboard.admin', compact('totalAdmins', 'totalPorteurs', 'totalCoachs', 'porteurs', 'selectedPorteur', 'selectedPorteurProgress'));
    }
    

    public function markAsRead($id)
{
    $notification = auth()->user()->notifications()->find($id);
    if ($notification) {
        $notification->update(['read' => true]);
    }

    return redirect()->back();
}

    
    
    



    
    





}
