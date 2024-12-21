<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportantAlertNotification extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $url;
    public $type;

    public function __construct($title, $message, $url = null, $type = 'autre')
    {

            $this->title = $title;
            $this->message = $message;
            $this->url = $url;
            $this->type = $type;

    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject($this->title)
            ->line($this->message)
            ->line('Merci d\'utiliser notre plateforme.');


        if ($this->url) {
            $mail->action('Voir plus', $this->url);
        }

        return $mail;
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'url' => $this->url,
            'type' => $this->type, // Correction ici
        ];
    }
}
