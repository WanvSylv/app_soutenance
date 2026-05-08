<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soutenance extends Model
{
    protected $fillable = [
        'etudiant_id',
        'annee_academique_id',
        'salle_id',
        'sujet',
        'date_heure_debut',
        'date_heure_fin',
        'statut',
        'convocations_envoyees',
        'convocations_envoyees_at',
        'created_by',
        'note_finale',
        'observations_generales',
    ];

    protected $casts = [
        'date_heure_debut' => 'datetime',
        'date_heure_fin' => 'datetime',
        'convocations_envoyees_at' => 'datetime',
    ];

    public function notifyStudent($type)
    {
        $mailable = match($type) {
            'convocation', 'modification_planification' => new \App\Mail\ConvocationMail($this),
            'annulation' => new \App\Mail\AnnulationMail($this),
            'resultat' => new \App\Mail\ResultatMail($this),
            default => new \App\Mail\ConvocationMail($this),
        };

        if ($type === 'modification_planification') {
            $mailable->subject = 'MODIFICATION : Convocation à votre Soutenance - HOREB IP';
        }

        $recipients = [$this->etudiant->user];

        if (in_array($type, ['convocation', 'modification_planification', 'annulation'])) {
            foreach ($this->juryMembres as $membre) {
                $recipients[] = $membre->enseignant->user;
            }
        }

        foreach ($recipients as $recipient) {
            // Notification in-app
            $notifTitle = match($type) {
                'convocation' => 'Nouvelle Convocation',
                'modification_planification' => 'Modification de Soutenance',
                'annulation' => 'Annulation de Soutenance',
                'resultat' => 'Résultat de Soutenance',
                default => 'Notification de Soutenance',
            };

            $notifMessage = match($type) {
                'convocation' => "Vous avez été convoqué pour la soutenance de {$this->etudiant->user->nom} le {$this->date_heure_debut->format('d/m/Y à H:i')}.",
                'modification_planification' => "L'horaire ou le lieu de la soutenance de {$this->etudiant->user->nom} a été modifié.",
                'annulation' => "La soutenance de {$this->etudiant->user->nom} prévue le {$this->date_heure_debut->format('d/m/Y')} a été annulée.",
                'resultat' => "Les résultats de la soutenance de {$this->etudiant->user->nom} sont disponibles.",
                default => "Mise à jour concernant une soutenance.",
            };

            $recipient->notify(new \App\Notifications\SimpleNotification($notifTitle, $notifMessage, route('dashboard')));

            try {
                \Illuminate\Support\Facades\Mail::to($recipient->email)->send($mailable);
                
                \App\Models\NotificationEmail::create([
                    'user_id' => $recipient->id,
                    'soutenance_id' => $this->id,
                    'type_notification' => $type,
                    'contenu' => 'Email envoyé avec succès',
                    'statut' => 'envoye',
                    'date_envoi' => now(),
                ]);

            } catch (\Exception $e) {
                \App\Models\NotificationEmail::create([
                    'user_id' => $recipient->id,
                    'soutenance_id' => $this->id,
                    'type_notification' => $type,
                    'contenu' => 'Erreur: ' . $e->getMessage(),
                    'statut' => 'erreur',
                    'date_envoi' => now(),
                ]);
            }
        }
        
        if ($type === 'convocation') {
            $this->update(['convocations_envoyees' => true, 'convocations_envoyees_at' => now()]);
        }
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class);
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function juryMembres()
    {
        return $this->hasMany(JuryMembre::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function procesVerbal()
    {
        return $this->hasOne(ProcesVerbal::class);
    }

    public function memoire()
    {
        return $this->hasOne(Memoire::class);
    }

    public function getJuryPresident()
    {
        return $this->juryMembres()->where('fonction', 'président')->first()?->enseignant;
    }

    public function isNotationComplete()
    {
        $juryCount = $this->juryMembres()->count();
        if ($juryCount === 0) return false;

        $enseignantsValides = $this->notes()
                                   ->where('valide', true)
                                   ->distinct('enseignant_id')
                                   ->count('enseignant_id');

        return $enseignantsValides === $juryCount;
    }

    public function calculateNoteFinale()
    {
        if (!$this->isNotationComplete()) {
            return 0;
        }

        $criteres = CritereEvaluation::where('actif', true)->get();
        $totalPondereGlobal = 0;
        $totalCoeffGlobal = 0;

        $juryIds = $this->juryMembres()->pluck('enseignant_id');

        foreach ($juryIds as $enseignantId) {
            $totalPondereEnseignant = 0;
            $totalCoeffEnseignant = 0;

            foreach ($criteres as $critere) {
                $note = $this->notes()->where('enseignant_id', $enseignantId)->where('critere_id', $critere->id)->first();
                if ($note) {
                    $totalPondereEnseignant += ($note->valeur * $critere->coefficient);
                    $totalCoeffEnseignant += $critere->coefficient;
                }
            }

            if ($totalCoeffEnseignant > 0) {
                $moyenneEnseignant = $totalPondereEnseignant / $totalCoeffEnseignant;
                // La note finale est la moyenne des moyennes des enseignants
                $totalPondereGlobal += $moyenneEnseignant;
                $totalCoeffGlobal += 1; 
            }
        }

        return $totalCoeffGlobal > 0 ? round($totalPondereGlobal / $totalCoeffGlobal, 2) : 0;
    }

    public static function getMention($note)
    {
        if ($note >= 16) return 'Très Bien';
        if ($note >= 14) return 'Bien';
        if ($note >= 12) return 'Assez Bien';
        if ($note >= 10) return 'Passable';
        return 'Ajourné';
    }
}
