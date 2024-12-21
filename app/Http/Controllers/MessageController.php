<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\ImportantAlertNotification;

class MessageController extends Controller
{
// app/Http/Controllers/MessageController.php

// Dans le MessageController


    public $message;

    public function index(Request $request)
    {
        $user = auth()->user();
    
        // Récupérer les utilisateurs pour la sélection dans le formulaire
        if ($user->role->name == 'coach') {
            $users = User::where('role_id', Role::where('name', 'porteur de projet')->first()->id)->get();
        } elseif ($user->role->name == 'porteur de projet') {
            $users = User::where('role_id', Role::where('name', 'coach')->first()->id)->get();
        } else {
            $users = collect(); // Si aucun rôle défini, retourne une collection vide
        }
    
        // Messages reçus
        $receivedMessages = Message::where('receiver_id', $user->id)
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'received');
    
        // Messages envoyés
        $sentMessages = Message::where('sender_id', $user->id)
            ->with('receiver')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'sent');
    
        return view('messages.index', compact('receivedMessages', 'sentMessages', 'users'));
    }
    
    public function send(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Données insérées dans messages :', [
            'sender_id' => $request->user()->id,
            'receiver_id' => $request->input('receiver_id'),
            'content' => $request->input('content')
        ]);


        // Ajoute la validation pour confirmer que `content` n'est pas null
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|min:1', // Assure-toi que `content` n'est pas vide
        ]);


        $message = Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $request->input('receiver_id'),
            'content' => (string) $request->input('content'), // conversion forcée
        ]);

        $message->receiver->notify(new ImportantAlertNotification(
            'Nouveau Message ', 
            "Vous avez reçu un nouveau message de {$message->sender->name}.",
            route('messages.inbox'),
                'message'
        ));

        // Appel de sendMessage pour diffuser le message en temps réel
        $this->sendMessage($message);
        return redirect()->route('messages.sent')->with('success', 'Message envoyé et notification créée');
    }





    public function sendMessage(Message $message)
    {
        // Log de début de diffusion
        \Illuminate\Support\Facades\Log::info('Début de la diffusion du message', ['message_id' => $message->id, 'content' => $message->content]);

        // Diffuse l'événement sans recréer le message
        broadcast(new MessageSent($message))->toOthers();

        \Illuminate\Support\Facades\Log::info('Le message a été diffusé aux autres utilisateurs', ['message_id' => $message->id]);

        return response()->json(['status' => 'Message diffusé!']);
    }

    public function inbox()
    {
        $user = auth()->user();
        $receivedMessages = Message::where('receiver_id', $user->id)
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        $unreadCount = Message::where('receiver_id', $user->id)->where('is_read', false)->count();
    
        return view('messages.inbox', compact('receivedMessages', 'unreadCount'));
    }
    
    

    public function read(Message $message)
    {
        // Vérifie que l'utilisateur est autorisé à voir ce message
        if ($message->receiver_id !== auth()->id() && $message->sender_id !== auth()->id()) {
            abort(403, 'Accès interdit');
        }
    
        // Marquer le message comme lu
        if ($message->receiver_id === auth()->id()) {
            $message->is_read = true;
            $message->save();
        }
    
        return view('messages.read', compact('message'));
    }
    


public function compose()
{
    $user = auth()->user();
    // Récupérer les utilisateurs disponibles selon le rôle de l'utilisateur connecté
    if ($user->role->name == 'coach') {
        $users = User::where('role_id', Role::where('name', 'porteur de projet')->first()->id)->get();
    } elseif ($user->role->name == 'porteur de projet') {
        $users = User::where('role_id', Role::where('name', 'coach')->first()->id)->get();
    } else {
        $users = collect(); // Si aucun rôle défini, retourne une collection vide
    }

    return view('messages.compose', compact('users'));
}

public function sent()
{
    $user = auth()->user();

    // Messages envoyés
    $sentMessages = Message::where('sender_id', $user->id)
        ->with('receiver')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    $unreadCount = Message::where('receiver_id', $user->id)->where('is_read', false)->count();

    return view('messages.sent', compact('sentMessages', 'unreadCount'))->with('type', 'sent');
}





}
