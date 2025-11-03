<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Alerta;

class AlertaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $alerta;

    public function __construct(Alerta $alerta)
    {
        $this->alerta = $alerta;
    }

    public function build()
    {
        return $this->subject("Alerta de Animal Detectado")
            ->markdown('emails.alerta');
    }
}
