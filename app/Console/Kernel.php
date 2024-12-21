<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Définit les commandes artisan disponibles.
     *
     * @var array
     */
// app/Console/Kernel.php
protected $commands = [
    \App\Console\Commands\CheckTaskDeadlines::class,
    \App\Console\Commands\SendAlerts::class,
];


    /**
     * Définit les tâches planifiées.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Commande pour les alertes
        $schedule->command('alerts:send')->hourly();
    
        // Commande pour vérifier les échéances des tâches toutes les minutes
        $schedule->command('tasks:check-deadlines')->everyMinute();
    }
    
    

    /**
     * Enregistrez les commandes pour l'application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
