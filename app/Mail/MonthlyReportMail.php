<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Rapport Mensuel')
            ->view('emails.monthly_report')
            ->attach(storage_path('app/public/rapport_mensuel.pdf'), [
                'as' => 'rapport_mensuel.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
