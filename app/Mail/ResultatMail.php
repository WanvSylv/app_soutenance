<?php

namespace App\Mail;

use App\Models\Soutenance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResultatMail extends Mailable
{
    use Queueable, SerializesModels;

    public $soutenance;

    /**
     * Create a new message instance.
     */
    public function __construct(Soutenance $soutenance)
    {
        $this->soutenance = $soutenance->load(['etudiant.user']);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Résultats de votre Soutenance de Mémoire - HOREB IP',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.resultat',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
