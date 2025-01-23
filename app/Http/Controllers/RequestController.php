<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ImportantAlertNotification;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function sendRelationRequest(Request $request)
    {
        $request->validate([
            'coach_id' => 'required|exists:users,id',
        ]);

        $coach = User::find($request->coach_id);

        if (!$coach || $coach->role->name !== 'coach') {
            return redirect()->back()->with('error', 'Le coach sélectionné est invalide.');
        }

        $admin = User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->first();

        if (!$admin) {
            return redirect()->back()->with('error', 'Aucun administrateur disponible pour traiter la demande.');
        }

        $admin->notify(new ImportantAlertNotification(
            "Demande de mise en relation",
            auth()->user()->name . " a demandé une mise en relation avec le coach " . $coach->name,
            route('admin.assign-coach-form'),
            'mise_en_relation'
        ));

        return redirect()->back()->with('success', 'Votre demande a été envoyée à l\'administrateur.');
    }
}
