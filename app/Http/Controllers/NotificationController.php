<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;



class NotificationController extends Controller
{
    public function index()
    {
        // Récupérer les notifications pour l'utilisateur connecté
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->get();

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return redirect()->back()->with('success', 'Notification marquée comme lue.');
    }

    public function delete($id)
{
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->delete();

    return response()->json([
        'success' => true,
        'unreadCount' => auth()->user()->unreadNotifications()->count(),
    ]);
}

    
}
