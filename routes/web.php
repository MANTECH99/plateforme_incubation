<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MentorshipSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SharedDocumentController;

use App\Http\Controllers\VideoController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\CoachWorkspaceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StatisticsController;

Route::get('/', [AuthController::class, 'showAuthForm'])->name('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes protégées pour le profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Routes d'inscription

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');


// Routes du tableau de bord pour chaque rôle
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'dashboardAdmin'])->name('admin.dashboard');
});


Route::middleware(['auth', 'role:porteur de projet'])->group(function () {
    // Tableau de bord du porteur
    Route::get('/porteur/dashboard', function () {
        return view('dashboard.porteur');
    })->name('porteur de projet.dashboard');

    Route::get('/porteur/dashboard', [DashboardController::class, 'dashboardPorteur'])->name('porteur de projet.dashboard');





    // Routes pour les projets du porteur
    Route::get('/porteur/projects', [ProjectController::class, 'porteurIndex'])->name('porteur.projects.index');
    Route::get('/porteur/projects/create', [ProjectController::class, 'create'])->name('porteur.projects.create');
    Route::post('/porteur/projects', [ProjectController::class, 'store'])->name('porteur.projects.store');
    Route::delete('/porteur/projects/{project}', [ProjectController::class, 'destroy'])->name('porteur.projects.destroy');
    Route::get('/workspace', [WorkspaceController::class, 'index'])->name('porteur.workspace');


    // Routes pour les resources du porteur
    Route::get('/porteur/resources', [ResourceController::class, 'index'])->name('porteur.resources.index');
});

Route::middleware(['auth', 'role:coach'])->group(function () {
    // Tableau de bord du coach
    Route::get('/coach/dashboard/projects', [ProjectController::class, 'coachIndex'])->name('coach.projects.dashboard');
    Route::get('/coach/dashboard', [DashboardController::class, 'coachDashboard'])->name('coach.dashboard');


    // Routes pour les projets du coach
    Route::get('/coach/projects', [ProjectController::class, 'coachIndex'])->name('coach.projects.index');
    Route::get('/coach/projects/{project}', [ProjectController::class, 'show'])->name('coach.projects.show');
    Route::post('/coach/projects/{project}/accompagner', [ProjectController::class, 'accompagner'])->name('coach.projects.accompagner');
    Route::get('/coach/projects/create', [ProjectController::class, 'create'])->name('coach.projects.create');
    Route::post('/coach/projects', [ProjectController::class, 'store'])->name('coach.projects.store');
    Route::get('/coach/workspace', [CoachWorkspaceController::class, 'index'])->name('coach.workspace');

    // Routes pour la gestion des tâches du coach
    Route::post('/coach/projects/{project}/tasks', [TaskController::class, 'store'])->name('coach.tasks.store');
    Route::patch('/coach/projects/{project}/tasks/{task}', [TaskController::class, 'update'])->name('coach.tasks.update');
    Route::delete('/coach/projects/{project}/tasks/{task}', [TaskController::class, 'destroy'])->name('coach.tasks.destroy');
});


Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/projects', [ProjectController::class, 'adminIndex'])->name('admin.projects.index');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::patch('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::patch('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

});


Route::get('/admin/assign-coach', [ProjectController::class, 'showAssignCoachForm'])->name('admin.assign-coach-form');
Route::post('/admin/assign-coach', [ProjectController::class, 'assignCoach'])->name('admin.assign-coach');




Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');
Route::post('/messages/sendMessage', [MessageController::class, 'sendMessage'])->name('messages.sendMessage');




Route::post('/broadcasting/auth', function (Request $request) {
    return Broadcast::auth($request);
})->middleware('web');


Route::resource('mentorship_sessions', MentorshipSessionController::class)->middleware('auth');

Route::post('/mentorship_sessions', [MentorshipSessionController::class, 'store'])->name('mentorship_sessions.store');



// Ressource pour Mentorship Sessions (CRUD)
Route::resource('mentorship_sessions', MentorshipSessionController::class)->middleware('auth');

// Route pour l'API des séances de mentorat
Route::get('/api/mentorship-sessions', [MentorshipSessionController::class, 'apiIndex'])
    ->name('mentorship_sessions.apiIndex')
    ->middleware('auth');



Route::get('/coach/{id}/profile', [CoachController::class, 'show'])->name('coach.profile');

Route::get('/coach/{id}/profile/edit', [CoachController::class, 'edit'])->name('coach.profile.edit');
Route::post('/coach/{id}/profile/update', [CoachController::class, 'update'])->name('coach.profile.update');

Route::get('/porteur/coaches', [CoachController::class, 'list'])->name('porteur.coaches');


Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/{id}/download', [ResourceController::class, 'download'])->name('resources.download');



Route::resource('resources', ResourceController::class)->middleware('auth');

Route::middleware(['auth', 'role:admin,coach'])->group(function () {
    Route::get('/resources/create', [ResourceController::class, 'create'])->name('resources.create');
    Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');
    Route::get('/resources/{id}/edit', [ResourceController::class, 'edit'])->name('resources.edit');
    Route::patch('/resources/{id}', [ResourceController::class, 'update'])->name('resources.update');
    Route::delete('/resources/{id}', [ResourceController::class, 'destroy'])->name('resources.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

Route::middleware('auth')->group(function () {
    Route::get('/documents', [SharedDocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/create', [SharedDocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [SharedDocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{id}/download', [SharedDocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{id}', [SharedDocumentController::class, 'destroy'])->name('documents.destroy');
});




Route::get('/porteur/projects/{project}/tasks', [ProjectController::class, 'showTasks'])->name('porteur.projects.tasks');





Route::get('/messages/compose', [MessageController::class, 'compose'])->name('messages.compose');
Route::get('/messages/inbox', [MessageController::class, 'inbox'])->name('messages.inbox');
Route::get('/messages/sent', [MessageController::class, 'sent'])->name('messages.sent');
Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');
Route::get('/messages/{message}', [MessageController::class, 'read'])->name('messages.read');


Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::patch('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

Route::post('/tasks/{task}/submit', [TaskController::class, 'submitWork'])->name('porteur.tasks.submit');

Route::get('/resources/{filename}', [ResourceController::class, 'show'])->name('resources.show');
Route::get('resources/download/{id}', [ResourceController::class, 'download'])->name('resources.download');



Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/videos/create', [VideoController::class, 'create'])->name('videos.create');
    Route::post('/videos', [VideoController::class, 'store'])->name('videos.store');
    Route::delete('/videos/{id}', [VideoController::class, 'destroy'])->name('videos.destroy');
    Route::get('videos/{id}/edit', [VideoController::class, 'edit'])->name('videos.edit');
    Route::put('videos/{id}', [VideoController::class, 'update'])->name('videos.update');

});

Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');

Route::middleware(['auth', 'role:admin'])->group(function() {

// Route pour la création de catégorie
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');

// Route pour voir toutes les catégories

Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
});
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/videos/{id}', [VideoController::class, 'show'])->name('videos.show');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

Route::post('/videos/{video}/comments', [CommentController::class, 'store'])->name('comments.store');



Route::middleware('web')->group(function () {
    Route::get('/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/callback/google', [GoogleAuthController::class, 'handleCallback'])->name('google.callback');
});


Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.editt');
Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.updatee');
Route::get('/profile/view', [UserController::class, 'showProfile'])->name('profile.view');

Route::post('/requests/relation', [RequestController::class, 'sendRelationRequest'])->name('requests.relation');


Route::get('/modal/create-project', function () {
    return view('modals.create_project_modal');
})->name('modal.create_project');


Route::get('/projects/{id}', [ProjectController::class, 'showProject'])->name('projects.show');




Route::prefix('porteur')->middleware('auth')->group(function () {
    // Route pour afficher le formulaire de modification
    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('porteur.projects.edit');
    // Route pour soumettre les modifications
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('porteur.projects.update');
});

Route::get('/reports', [ReportController::class, 'generateReport'])->name('report.generate');
Route::get('/reports/export', [ReportController::class, 'export'])->name('report.export');

Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
Route::get('/statistics/export/pdf', [StatisticsController::class, 'exportPDF'])->name('statistics.export.pdf');
Route::get('/statistics/export/excel', [StatisticsController::class, 'exportExcel'])->name('statistics.export.excel');











