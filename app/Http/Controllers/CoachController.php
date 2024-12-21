<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


use App\Models\User;

class CoachController extends Controller
{
    public function show($id)
    {
        $coach = User::findOrFail($id);
        return view('profile', compact('coach'));
    }

    public function edit($id)
{
    $coach = User::findOrFail($id);
    return view('edit-profile', compact('coach'));
}

public function update(Request $request, $id)
{
    $coach = User::findOrFail($id);
    $coach->update($request->only(['bio', 'expertise', 'experience']));
    return redirect()->route('coach.profile', $coach->id)->with('success', 'Profil mis à jour.');
}

public function list()
{
    // Récupère tous les coachs ayant le rôle 'coach'
    $coaches = User::whereHas('role', function ($query) {
        $query->where('name', 'coach');
    })->get();

    return view('porteur.coaches', compact('coaches'));
}




}
