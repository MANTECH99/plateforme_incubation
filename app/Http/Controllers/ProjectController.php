<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Affiche tous les projets suivis par le coach
    public function index()
    {
        $projects = Project::where('coach_id', auth()->id())->get();
        return view('dashboard.coach.projects.index', compact('projects'));
    }

    // Affiche les détails d'un projet
    public function show(Project $project)
    {
        // Vérifie que le coach est assigné au projet ou que le projet n’a pas encore de coach
        if ($project->coach_id !== auth()->id() && $project->coach_id !== null) {
            abort(403, 'Accès interdit');
        }
        $tasks = $project->tasks;
            // Parcourir chaque tâche pour vérifier et mettre à jour son statut si nécessaire
    foreach ($tasks as $task) {
        if ($task->due_date && now()->greaterThan($task->due_date) && $task->status != 'soumis') {
            $task->update(['status' => 'non accompli']); // Met à jour la base de données
        }
    }

        return view('dashboard.coach.projects.show', compact('project'));
    }

    public function create()
    {
        if (auth()->user()->role->name === 'coach') {
            return view('dashboard.coach.projects.create');
        } else {
            return view('dashboard.porteur.projects.create');
        }
    }



    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'objectives' => 'required|string',
            'budget' => 'required|numeric',
            'sector' => 'required|string',
            'status' => 'required|string|in:en cours,à venir,terminé,annulé',
            'start_date' => 'nullable|date',
            'partners' => 'nullable|string',
            'team_members' => 'nullable|array',
            'risks' => 'nullable|string',
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,xlsx|max:2048',
        ]);

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'objectives' => $request->objectives,
            'budget' => $request->budget,
            'sector' => $request->sector,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'partners' => $request->partners,
            'team_members' => $request->team_members ? json_encode($request->team_members) : null,
            'risks' => $request->risks,
            'user_id' => auth()->id(),
            'coach_id' => auth()->user()->role->name === 'coach' ? auth()->id() : null,
        ]);

        // Gérer les fichiers associés
        if ($request->hasFile('documents')) {
            $documentPaths = [];
            foreach ($request->file('documents') as $file) {
                $filePath = $file->store('project_documents', 'public');
                $documentPaths[] = $filePath;
            }
            // Mettre à jour la colonne documents avec les chemins
            $project->update(['documents' => json_encode($documentPaths)]);
        }


        return redirect()
            ->route(auth()->user()->role->name === 'coach' ? 'coach.projects.index' : 'porteur.projects.index')
            ->with('success', 'Projet créé avec succès.');
    }


    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'objectives' => 'required|string',
            'budget' => 'required|numeric',
            'sector' => 'required|string',
            'status' => 'required|string|in:en cours,à venir,terminé,annulé',
            'start_date' => 'nullable|date',
            'partners' => 'nullable|string',
            'team_members' => 'nullable|array',
            'risks' => 'nullable|string',
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,xlsx|max:2048',
        ]);

        // Trouver le projet existant
        $project = Project::findOrFail($id);

        // Mise à jour des valeurs du projet
        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'objectives' => $request->objectives,
            'budget' => $request->budget,
            'sector' => $request->sector,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'partners' => $request->partners,
            'team_members' => $request->team_members ? json_encode($request->team_members) : null,
            'risks' => $request->risks,
        ]);

        // Gérer les fichiers associés (si présents)
        if ($request->hasFile('documents')) {
            $documentPaths = [];
            foreach ($request->file('documents') as $file) {
                $filePath = $file->store('project_documents', 'public');
                $documentPaths[] = $filePath;
            }
            // Mettre à jour la colonne `documents` avec les chemins
            $project->update(['documents' => json_encode($documentPaths)]);
        }

        // Rediriger après la modification
        return redirect()
            ->route(auth()->user()->role->name === 'coach' ? 'coach.projects.index' : 'porteur.projects.index')
            ->with('success', 'Projet modifié avec succès.');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id); // Récupère le projet à modifier
        return view('dashboard.porteur.projects.edit', compact('project')); // Passe le projet à la vue
    }


    public function showProject($id)
    {
        $project = Project::with(['user', 'tasks'])->findOrFail($id);

        return view('dashboard.porteur.projects.show', compact('project'));
    }



    public function porteurIndex()
    {
        $projects = Project::where('user_id', auth()->id())->with('tasks', 'coach')->get();
        return view('dashboard.porteur.projects.index', compact('projects'));
    }

    public function adminIndex()
    {
        $projects = Project::with('user', 'coach')->get();
        return view('dashboard.admin.projects.index', compact('projects'));
    }


    public function coachIndex()
    {
        // Affiche tous les projets soumis pour permettre au coach de choisir ceux qu’il souhaite accompagner
        $projects = Project::whereNull('coach_id')->orWhere('coach_id', auth()->id())->with('user')->get();
        return view('dashboard.coach.projects.index', compact('projects'));
    }

    public function accompagner(Project $project)
    {
        // Assigne le coach connecté au projet
        $project->coach_id = auth()->id();
        $project->save();

        return redirect()->route('coach.projects.index')->with('success', 'Vous avez commencé à accompagner ce projet.');
    }



// Dans ProjectController.php

    public function showAssignCoachForm()
    {
        // Récupérer les projets sans coach assigné
        $projects = Project::whereNull('coach_id')->get();

        // Récupérer uniquement les utilisateurs ayant le rôle de coach
        $coaches = User::whereHas('role', function ($query) {
            $query->where('name', 'coach');
        })->get();

        return view('admin.assign_coach', compact('projects', 'coaches'));
    }


// Assigne le coach au projet
    public function assignCoach(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'coach_id' => 'required|exists:users,id',
        ]);

        // Récupère le projet et assigne le coach en mettant à jour le champ coach_id
        $project = Project::find($request->project_id);
        $project->coach_id = $request->coach_id;
        $project->save();

        return redirect()->route('admin.assign-coach-form')->with('success', 'Coach assigné avec succès au projet.');
    }

    public function showTasks($projectId)
    {
        $project = Project::with('tasks')->findOrFail($projectId);
        $tasks = $project->tasks;

        return view('dashboard.porteur.projects.tasks', compact('tasks', 'project'));
    }


    public function destroy(Project $project)
{
    // Vérifiez que l'utilisateur connecté est le propriétaire du projet
    if ($project->user_id !== auth()->id()) {
        abort(403, 'Vous n\'êtes pas autorisé à supprimer ce projet.');
    }

    $project->delete();

    return redirect()->route('porteur.projects.index')->with('success', 'Projet supprimé avec succès.');
}


}
