<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Project;

class UserController extends Controller
{
    // Affiche tous les utilisateurs pour l'administrateur
    public function index()
    {
        $users = User::all();
        $roles = Role::all(); // Récupère tous les rôles
        return view('dashboard.admin.users.index', compact('users', 'roles'));
    }

    // Affiche le formulaire d'édition pour un utilisateur spécifique
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all(); // Récupère tous les rôles disponibles pour les assigner à un utilisateur
    
        return view('dashboard.admin.users.edit', compact('user', 'roles'));
    }
    
    // Met à jour les informations de l'utilisateur
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update($request->only('name', 'email', 'role_id'));

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    // Affiche le formulaire de création d'un utilisateur
    public function create()
    {
        $roles = Role::all(); // Récupère tous les rôles pour les afficher dans le formulaire
        return view('dashboard.admin.users.create', compact('roles'));
    }

    // Enregistre un nouvel utilisateur dans la base de données
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    public function editProfile()
{
    $user = auth()->user(); // Récupère l'utilisateur connecté
    return view('profile.editt', compact('user'));
}

public function updateProfile(Request $request)
{
    $request->validate([
        'fonction' => 'nullable|string|max:255',
        'genre' => 'nullable|in:Homme,Femme',
        'biographie' => 'nullable|string|max:1000',
        'telephone' => 'nullable|string|max:20',
        'ville' => 'nullable|string|max:255',
        'date_naissance' => 'nullable|date',
        'instagram' => 'nullable|string|max:255',
        'facebook' => 'nullable|string|max:255',
        'linkedin' => 'nullable|string|max:255',
        'twitter' => 'nullable|string|max:255',
        'startup_nom' => 'nullable|string|max:255',
        'startup_slogan' => 'nullable|string|max:255',
        'expertise' => 'nullable|string|max:1000',
        'startup_adresse' => 'nullable|string|max:255',
        'startup_secteur' => 'nullable|string|max:255',
        'experience' => 'nullable|string|max:1000',
        'pitch' => 'nullable|string|max:2000',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = auth()->user();

    // Mettre à jour les données utilisateur
    $user->update([
        'fonction' => $request->fonction,
        'genre' => $request->genre,
        'biographie' => $request->biographie,
        'telephone' => $request->telephone,
        'ville' => $request->ville,
        'date_naissance' => $request->date_naissance,
        'instagram' => $request->instagram,
        'facebook' => $request->facebook,
        'linkedin' => $request->linkedin,
        'twitter' => $request->twitter,
        'startup_nom' => $request->startup_nom,
        'startup_slogan' => $request->startup_slogan,
        'expertise' => $request->expertise,
        'startup_adresse' => $request->startup_adresse,
        'startup_secteur' => $request->startup_secteur,
        'experience' => $request->experience,
        'pitch' => $request->pitch,
    ]);

    if ($request->hasFile('profile_picture')) {
        $fileName = $user->id . '_profile.' . $request->profile_picture->getClientOriginalExtension();
        $filePath = $request->file('profile_picture')->storeAs('profile_pictures', $fileName, 'public'); // Sauvegarde dans storage/app/public/profile_pictures
        $user->update(['profile_picture' => $filePath]); // Stocke le chemin relatif dans la base de données
    }

    
    

    return redirect()->route('profile.view')->with('success', 'Profil mis à jour avec succès.');
}



public function showProfile()
{
    $user = Auth::user(); // Récupère l'utilisateur actuellement connecté
    
    // Récupère les projets liés à cet utilisateur
    $projects = Project::where('user_id', $user->id)->get(); 

    // Récupère toutes les tâches associées aux projets de l'utilisateur
    $tasks = Task::whereIn('project_id', $projects->pluck('id'))->get();

    // Retourne la vue avec les informations de l'utilisateur et les tâches
    return view('profile.view', compact('user', 'tasks'));
}


public function destroy(User $user)
{
    // Vérifiez le rôle de l'utilisateur
    if ($user->role->name === 'porteur de projet') {
        // Supprime les projets et leurs tâches associés
        $projects = Project::where('user_id', $user->id)->get();
        foreach ($projects as $project) {
            // Supprime les tâches associées
            $project->tasks()->delete();
            $project->delete();
        }
    } elseif ($user->role->name === 'coach') {
        // Supprime les projets qu'il accompagne
        $projects = Project::where('coach_id', $user->id)->get();
        foreach ($projects as $project) {
            $project->delete();
        }
    }

    // Supprime l'utilisateur
    $user->delete();

    return redirect()->route('admin.users.index')->with('success', 'Utilisateur et ses données associés supprimés avec succès.');
}



}
