<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Carbon\Carbon;

class CheckTaskDeadlines extends Command
{
    protected $signature = 'tasks:check-deadlines';
    protected $description = 'Vérifie si les tâches sont accomplies avant leurs échéances';

    public function handle()
    {
        $now = Carbon::now();
    
        $tasks = Task::where('status', '!=', 'soumis')
            ->where('due_date', '<', $now)
            ->get();

            if ($tasks->isEmpty()) {
                $this->info("Aucune tâche à vérifier.");
            }
    
        foreach ($tasks as $task) {
            $task->update(['status' => 'non accompli']);
            $this->info("Tâche marquée comme non accomplie : {$task->title}");
        }
    }
    
}
