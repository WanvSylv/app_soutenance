<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Soutenance;
use App\Models\NotificationEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ProcessSoutenanceNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-soutenance-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Traite les rappels à 24h et les ouvertures de délibération pour les soutenances';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Début du traitement des notifications de soutenance...");

        $this->processRappels();
        $this->processOuvertureDeliberation();

        $this->info("Traitement terminé.");
    }

    private function processRappels()
    {
        // Soutenances prévues entre dans 24h et 25h
        $demainDebut = Carbon::now()->addHours(23);
        $demainFin = Carbon::now()->addHours(25);

        $soutenances = Soutenance::whereBetween('date_heure_debut', [$demainDebut, $demainFin])
                                 ->where('statut', 'planifiee')
                                 ->get();

        foreach ($soutenances as $soutenance) {
            // Check si déjà envoyé (pour éviter doublons)
            $dejaEnvoye = NotificationEmail::where('soutenance_id', $soutenance->id)
                                           ->where('type_notification', 'rappel_24h')
                                           ->exists();

            if (!$dejaEnvoye) {
                // Envoyer à l'étudiant
                $this->sendMail($soutenance->etudiant->user, new \App\Mail\RappelSoutenanceMail($soutenance, $soutenance->etudiant->user), $soutenance, 'rappel_24h');

                // Envoyer au jury
                foreach ($soutenance->juryMembres as $membre) {
                    $this->sendMail($membre->enseignant->user, new \App\Mail\RappelSoutenanceMail($soutenance, $membre->enseignant->user), $soutenance, 'rappel_24h_jury');
                }
            }
        }
    }

    private function processOuvertureDeliberation()
    {
        // Soutenances dont la date de fin vient de passer (dans la dernière heure)
        $ilYaUneHeure = Carbon::now()->subHour();
        $maintenant = Carbon::now();

        $soutenances = Soutenance::whereBetween('date_heure_fin', [$ilYaUneHeure, $maintenant])
                                 ->where('statut', 'planifiee') // Encore en statut planifiée (non terminée)
                                 ->get();

        foreach ($soutenances as $soutenance) {
            $dejaEnvoye = NotificationEmail::where('soutenance_id', $soutenance->id)
                                           ->where('type_notification', 'ouverture_deliberation')
                                           ->exists();

            if (!$dejaEnvoye) {
                foreach ($soutenance->juryMembres as $membre) {
                    $this->sendMail($membre->enseignant->user, new \App\Mail\OuvertureDeliberationMail($soutenance), $soutenance, 'ouverture_deliberation');
                }
            }
        }
    }

    private function sendMail($user, $mailable, $soutenance, $type)
    {
        try {
            Mail::to($user->email)->send($mailable);

            NotificationEmail::create([
                'user_id' => $user->id,
                'soutenance_id' => $soutenance->id,
                'type_notification' => $type,
                'contenu' => 'Email ' . $type . ' envoyé avec succès à ' . $user->email,
                'statut' => 'envoye',
                'date_envoi' => now(),
            ]);

            $this->info("Email envoyé: $type à {$user->email}");
        } catch (\Exception $e) {
            Log::error("Erreur commande notification ($type) vers {$user->email} : " . $e->getMessage());
            
            NotificationEmail::create([
                'user_id' => $user->id,
                'soutenance_id' => $soutenance->id,
                'type_notification' => $type,
                'contenu' => 'Erreur: ' . $e->getMessage(),
                'statut' => 'erreur',
                'date_envoi' => now(),
            ]);
        }
    }
}
