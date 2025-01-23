<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Import de View
use Illuminate\Support\Facades\Auth; // Import de Auth
use App\Models\Message;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // View Composer pour partager les messages récents, notifications, et les décomptes sur toutes les vues
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                // Messages
                $unreadMessagesCount = $user->receivedMessages()->where('is_read', false)->count();
                $recentMessages = $user->receivedMessages()->latest()->take(5)->get();

                // Notifications
                $unreadNotificationsCount = $user->unreadNotifications()->count();
                $recentNotifications = $user->notifications()->latest()->take(5)->get();

                // Partage des données avec toutes les vues
                $view->with(compact(
                    'unreadMessagesCount',
                    'recentMessages',
                    'unreadNotificationsCount',
                    'recentNotifications',
                    'user'
                ));
            }
        });
    }
}
