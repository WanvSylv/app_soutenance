<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Soutenance;
use App\Models\Enseignant;

class JuryResponseNotification extends Notification
{
    use Queueable;

    protected $soutenance;
    protected $enseignant;
    protected $statut;

    /**
     * Create a new notification instance.
     */
    public function __construct(Soutenance $soutenance, Enseignant $enseignant, $statut)
    {
        $this->soutenance = $soutenance;
        $this->enseignant = $enseignant;
        $this->statut = $statut;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $statusText = $this->statut === 'confirme' ? 'confirmé sa présence' : 'décliné sa participation (indisponible)';
        $etudiantName = $this->soutenance->etudiant->user->nom . ' ' . $this->soutenance->etudiant->user->prenom;
        
        return [
            'title' => 'Réponse Jury : ' . ($this->statut === 'confirme' ? 'Confirmation' : 'Indisponibilité'),
            'message' => "L'enseignant {$this->enseignant->user->nom} {$this->enseignant->user->prenom} a {$statusText} pour la soutenance de {$etudiantName}.",
            'soutenance_id' => $this->soutenance->id,
            'statut' => $this->statut,
            'url' => route('planification.index'), // Rediriger vers le planning pour voir les détails
            'type' => 'jury_response'
        ];
    }
}
