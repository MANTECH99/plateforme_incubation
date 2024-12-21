<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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


}
