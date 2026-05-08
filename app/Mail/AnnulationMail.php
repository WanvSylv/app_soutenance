<?php

namespace App\Mail;

use App\Models\Soutenance;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AnnulationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $soutenance;

    public function __construct(Soutenance $soutenance)
    {
        $this->soutenance = $soutenance->load(['etudiant.user']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Annulation de votre Soutenance de Mémoire - HOREB IP',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.annulation',
        );
    }
}
