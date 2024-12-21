<?php
namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    // Assurez-vous que le constructeur attend bien un modèle Message
    public function __construct($message)
    {
        $this->message = $message;
        \Illuminate\Support\Facades\Log::info('Événement MessageSent créé', ['message' => $message]);
    }
    public function broadcastOn()
    {
        return new PrivateChannel('chat');
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }

    public function broadcastWith()
    {
        \Illuminate\Support\Facades\Log::info('Méthode broadcastWith de MessageSent appelée');
        return [
            'message' => [
                'sender' => [
                    'name' => $this->message->sender->name,
                ],
                'content' => $this->message->content,
            ],
        ];
    }
}
