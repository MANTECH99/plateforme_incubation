<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Méthode pour afficher le formulaire d'authentification (inscription et connexion)
    public function showAuthForm()
    {
        $roles = Role::all(); // Pour permettre de choisir le rôle lors de l'inscription
        return view('auth.auth', compact('roles'));
    }

    // Méthode pour gérer l'inscription
    public function register(Request $request)
    {
        // Valider les données du formulaire d'inscription
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id', // Valider que le role_id est un ID existant
        ]);

        // Créer l'utilisateur et forcer la conversion de role_id en entier
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => (int) $request->role_id, // Conversion explicite
        ]);

        // Connecter l'utilisateur
        Auth::login($user);

        // Redirection selon le rôle
        return $this->redirectBasedOnRole($user);
    }

    // Méthode pour gérer la connexion
    public function login(Request $request)
    {
        // Valider les données du formulaire de connexion
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Tenter de connecter l'utilisateur
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Redirection selon le rôle de l'utilisateur connecté
            return $this->redirectBasedOnRole(Auth::user());
        }

        // Si la connexion échoue, rediriger avec un message d'erreur
        return back()->withErrors([
            'email' => 'Les informations d’identification ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    // Méthode pour rediriger selon le rôle
    protected function redirectBasedOnRole($user)
    {
        if ($user->role->name == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role->name == 'porteur de projet') {
            return redirect()->route('porteur de projet.dashboard');
        } elseif ($user->role->name == 'coach') {
            return redirect()->route('coach.dashboard');
        }

        return redirect()->route('home');
    }
}
