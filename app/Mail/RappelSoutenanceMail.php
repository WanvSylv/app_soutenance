<?php

namespace App\Mail;

use App\Models\Soutenance;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RappelSoutenanceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $soutenance;
    public $user;

    public function __construct(Soutenance $soutenance, User $user)
    {
        $this->soutenance = $soutenance;
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'RAPPEL : Votre soutenance est prévue dans 24h',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.rappel_soutenance',
        );
    }
}
