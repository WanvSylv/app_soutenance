<?php

namespace App\Mail;

use App\Models\Memoire;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MemoireStatutMail extends Mailable
{
    use Queueable, SerializesModels;

    public Memoire $memoire;
    public string $typeStatut; // 'valide' | 'rejete' | 'corrections_demandees'
    public ?string $motif;

    public function __construct(Memoire $memoire, string $typeStatut, ?string $motif = null)
    {
        $this->memoire = $memoire->load(['etudiant.user', 'anneeAcademique']);
        $this->typeStatut = $typeStatut;
        $this->motif = $motif;
    }

    public function envelope(): Envelope
    {
        $subjects = [
            'valide'                => 'Mémoire validé - HOREB IP',
            'rejete'                => 'Mémoire rejeté - HOREB IP',
            'corrections_demandees' => 'Corrections demandées pour votre mémoire - HOREB IP',
        ];

        return new Envelope(
            subject: $subjects[$this->typeStatut] ?? 'Mise à jour statut mémoire - HOREB IP',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.memoire_statut',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
