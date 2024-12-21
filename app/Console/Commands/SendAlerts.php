<?php
namespace App\Console\Commands;

use App\Models\MentorshipSession;
use App\Models\Task;
use App\Notifications\ImportantAlertNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendAlerts extends Command
{
    protected $signature = 'alerts:send';
    protected $description = 'Envoyer des alertes importantes aux utilisateurs';

    public function handle()
    {
        $now = Carbon::now();

        Log::info('Execution de SendAlerts : heure actuelle', ['now' => $now]);

        // Plage horaire pour les séances
        $sessions = MentorshipSession::with('project', 'coach')
            ->where('start_time', '>', $now->copy())
            ->where('start_time', '<=', $now->copy()->addDay())
            ->get();

        Log::info('Plage horaire des séances recherchées', [
            'now' => $now,
            'start_range' => $now->copy(),
            'end_range' => $now->copy()->addDay(),
        ]);

        Log::info('Séances récupérées pour les alertes', ['sessions' => $sessions->toArray()]);

        foreach ($sessions as $session) {
            if ($session->coach) {
                $session->coach->notify(new ImportantAlertNotification(
                    'Rappel : Séance de mentorat',
                    "Vous avez une séance de mentorat prévue avec le projet {$session->project->title}.",
                    config('app.url') . route('mentorship_sessions.index', [], false),
                        'séance'
                ));
                Log::info('Notification envoyée au coach', ['coach_id' => $session->coach->id]);
            }

            if ($session->project && $session->project->user) {
                $session->project->user->notify(new ImportantAlertNotification(
                    'Rappel : Séance de mentorat',
                    "Une séance de mentorat est prévue avec votre coach sur le projet {$session->project->title}.",
                    config('app.url') . route('mentorship_sessions.index', [], false),
                        'séance'
                ));
                Log::info('Notification envoyée au porteur', ['user_id' => $session->project->user->id]);
            }
        }

// Alertes pour les échéances de tâches
$tasks = Task::with('project.user', 'project.coach')
    ->where('due_date', '>', $now->copy())
    ->where('due_date', '<=', $now->copy()->addDay())
    ->where('alerted', false) // Exclure les tâches déjà alertées
    ->get();

Log::info('Tâches récupérées pour les alertes', ['tasks' => $tasks->toArray()]);

foreach ($tasks as $task) {
    // Notification pour le porteur de projet
    if ($task->project && $task->project->user) {
        $task->project->user->notify(new ImportantAlertNotification(
            'Rappel : Échéance de tâche',
            "La tâche '{$task->title}' doit être achevée d'ici demain.",
            route('porteur.projects.tasks', $task->project->id), // Lien vers les tâches du projet pour le porteur
                'tâche'
        ));
        Log::info('Notification envoyée au porteur pour la tâche', [
            'task_id' => $task->id,
            'user_id' => $task->project->user->id,
        ]);
    }

    // Notification pour le coach
    if ($task->project && $task->project->coach) {
        $task->project->coach->notify(new ImportantAlertNotification(
            'Rappel : Échéance de tâche',
            "La tâche '{$task->title}' doit être achevée d'ici demain.",
            route('coach.projects.show', $task->project->id), // Lien vers les tâches du projet pour le coach
                'tâche'
        ));
        Log::info('Notification envoyée au coach pour la tâche', [
            'task_id' => $task->id,
            'coach_id' => $task->project->coach->id,
        ]);
    }
        // Marquer la tâche comme alertée
        $task->update(['alerted' => true]);
}


        $this->info('Alertes envoyées.');
    }
}
