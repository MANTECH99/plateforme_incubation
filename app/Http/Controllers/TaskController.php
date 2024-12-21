<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Notifications\ImportantAlertNotification;

class TaskController extends Controller
{

    // Méthode pour ajouter une nouvelle tâche
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'to_do_file' => 'nullable|file|mimes:pdf,doc,docx,xlsx,png,jpg,jpeg,zip,rar|max:2048',
            'status' => 'required|string|in:en attente,en cours,terminé',
            'due_date' => 'nullable|date',
        ]);

            // Gérer le fichier uploadé
    $filePath = null;
    if ($request->hasFile('to_do_file')) {
        $filePath = $request->file('to_do_file')->store('to_do_files', 'public');
    }
        // Créer la tâche avec le statut et l'échéance fournis par le coach
        $task = $project->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'to_do_file' => $filePath, // Enregistrer le chemin du fichier
            'status' => $request->status,
            'due_date' => $request->due_date,
            'progress' => 0, // Initialise la progression à 0%
        ]);

   // Vérifiez si la tâche a bien été créée
   if ($task && $project->user) {
    // Notifier le porteur de projet associé au projet
    $project->user->notify(new ImportantAlertNotification(
        'Nouvelle Tâche Assignée',
        "Une nouvelle tâche '{$task->title}' a été créée pour le projet '{$project->title}'.",
        route('porteur.projects.tasks', $project->id),
        'tâche'
    ));
}

return redirect()->route('coach.projects.show', $project->id)
    ->with('success', 'Tâche ajoutée avec succès et notification envoyée.');
}

    // Méthode pour mettre à jour une tâche existante
    public function update(Request $request, Project $project, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:en attente,en cours,terminé',
            'due_date' => 'nullable|date',
        ]);

        // Mettre à jour les informations de la tâche
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
        ]);

        if ($task->status === 'en cours' && $project->user) {
            $project->user->notify(new ImportantAlertNotification(
                "Tâche mise à jour : {$task->title}",
                "Votre tâche '{$task->title}' est maintenant marquée comme en cours.",
                route('porteur.projects.tasks', $project->id),
                'tâche'
            ));
        }
        

        return redirect()->route('coach.projects.show', $project->id)->with('success', 'Tâche mise à jour avec succès.');
    }


    public function destroy(Project $project, Task $task)
    {
        $task->delete();

        return redirect()->route('coach.projects.show', $project->id)->with('success', 'Tâche supprimée avec succès.');
    }

    
    public function submitWork(Request $request, Task $task)
    {
        // Vérifier si la date d'échéance est dépassée
        if ($task->due_date && now()->greaterThan($task->due_date)) {
            return redirect()->back()->with('error', 'Vous ne pouvez plus soumettre le travail, car la date d\'échéance est passée.');
        }
    
        $request->validate([
            'submission' => 'required|file',
        ]);
    
        // Sauvegarder le fichier soumis
        $filePath = $request->file('submission')->store('submissions', 'public');
    
        // Mise à jour du statut et de la progression
        $task->submission = $filePath;
        $task->status = 'soumis';  // Mettre à jour le statut
        $task->progress = 100;     // Mettre la progression à 100%
        $task->save();  // Sauvegarder les modifications dans la base de données
    
        // Rechargez le modèle pour valider la mise à jour
        $task->refresh();
    
        // Vérifiez si les données ont été correctement mises à jour
        if ($task->progress !== 100) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour de la progression.');
        }
    
        return redirect()->back()->with('success', 'Travail soumis avec succès.');
    }
    
    
    

    
    
    
    
    

    

}
