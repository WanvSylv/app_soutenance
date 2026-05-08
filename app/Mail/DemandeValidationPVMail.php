<?php

namespace App\Mail;

use App\Models\Soutenance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DemandeValidationPVMail extends Mailable
{
    use Queueable, SerializesModels;

    public $soutenance;

    public function __construct(Soutenance $soutenance)
    {
        $this->soutenance = $soutenance;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ACTION REQUISE : Validation finale de délibération',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.demande_validation_pv',
        );
    }
}
