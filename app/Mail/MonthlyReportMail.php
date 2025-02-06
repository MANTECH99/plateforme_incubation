<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $pdfPath;
    public $excelPath;

    public function __construct($data, $pdfPath, $excelPath)
    {
        $this->data = $data;
        $this->pdfPath = $pdfPath;
        $this->excelPath = $excelPath;
    }

    public function build()
    {
        return $this->subject('Rapport Mensuel')
            ->view('emails.monthly_report') // Vue de l'e-mail
            ->attach($this->pdfPath, [
                'as' => 'rapport_mensuel.pdf',
                'mime' => 'application/pdf',
            ])
            ->attach($this->excelPath, [
                'as' => 'rapport_mensuel.xlsx',
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
    }
}
