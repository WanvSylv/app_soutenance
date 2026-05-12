<?php

namespace Database\Seeders;

use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Soutenance;
use App\Models\Memoire;
use App\Models\JuryMembre;
use App\Models\Note;
use App\Models\CritereEvaluation;
use Illuminate\Database\Seeder;

class SoutenanceMemoireSeeder extends Seeder
{
    public function run(): void
    {
        $anneeActiveId = 3; // 2025-2026
        $adminId       = 1;

        $etudiants  = Etudiant::with('user')->get();
        $enseignants = Enseignant::all();
        $criteres   = CritereEvaluation::all();

        $sujets = [
            'Développement d\'une application de gestion des soutenances académiques',
            'Mise en place d\'un système de détection d\'intrusion basé sur l\'IA',
            'Conception d\'une plateforme e-learning pour l\'enseignement supérieur',
            'Implémentation d\'un réseau SDN pour l\'optimisation du trafic',
            'Développement d\'un chatbot intelligent pour le service client',
            'Sécurisation des transactions bancaires mobiles par biométrie',
            'Analyse prédictive des performances académiques par Machine Learning',
            'Conception d\'une infrastructure cloud hybride pour les PME',
        ];

        // On crée des soutenances pour les 8 premiers étudiants avec quitus valide
        $etudiantsAvecQuitus = $etudiants->where('quitus_valide', true)->values();

        $salleIds = [1, 2, 3, 4, 5];
        $statuts  = ['terminee', 'terminee', 'terminee', 'planifiee', 'planifiee', 'planifiee', 'deliberee', 'terminee'];

        foreach ($etudiantsAvecQuitus->take(8) as $index => $etudiant) {
            $dateBase = now()->subDays(rand(5, 30));
            if (in_array($statuts[$index], ['planifiee'])) {
                $dateBase = now()->addDays(rand(5, 20));
            }

            $debut = $dateBase->setHour(rand(8, 15))->setMinute(0)->setSecond(0)->copy();
            $fin   = $debut->copy()->addHours(2);

            $soutenance = Soutenance::create([
                'etudiant_id'          => $etudiant->id,
                'annee_academique_id'  => $anneeActiveId,
                'salle_id'             => $salleIds[$index % count($salleIds)],
                'sujet'                => $sujets[$index],
                'date_heure_debut'     => $debut,
                'date_heure_fin'       => $fin,
                'statut'               => $statuts[$index],
                'convocations_envoyees' => true,
                'convocations_envoyees_at' => now()->subDays(rand(1, 10)),
                'created_by'           => $adminId,
            ]);

            // Mémoire associé
            Memoire::create([
                'etudiant_id'         => $etudiant->id,
                'soutenance_id'       => $soutenance->id,
                'annee_academique_id' => $anneeActiveId,
                'titre'               => $sujets[$index],
                'resume'              => 'Ce mémoire présente une étude approfondie sur ' . strtolower($sujets[$index]) . '. Il propose une solution innovante répondant aux enjeux actuels du domaine.',
                'fichier_path'        => 'memoires/' . $etudiant->matricule . '_memoire.pdf',
                'taille_fichier_ko'   => rand(2000, 8000),
                'date_depot'          => now()->subDays(rand(15, 45)),
                'statut'              => 'valide',
                'valide_at'           => now()->subDays(rand(5, 14)),
                'valide_par'          => $adminId,
            ]);

            // Jury : 3 enseignants différents (rotation)
            $juryEnseignants = $enseignants->shuffle()->take(3);
            $fonctions = ['président', 'rapporteur', 'examinateur'];

            foreach ($juryEnseignants as $jIdx => $enseignant) {
                $jury = JuryMembre::create([
                    'soutenance_id'       => $soutenance->id,
                    'enseignant_id'       => $enseignant->id,
                    'fonction'            => $fonctions[$jIdx],
                    'invite_envoye'       => true,
                    'invite_envoye_at'    => now()->subDays(rand(3, 10)),
                    'statut_confirmation' => 'confirme',
                ]);

                // Notes si soutenance terminée ou délibérée
                if (in_array($soutenance->statut, ['terminee', 'deliberee'])) {
                    foreach ($criteres as $critere) {
                        Note::create([
                            'soutenance_id' => $soutenance->id,
                            'enseignant_id' => $enseignant->id,
                            'critere_id'    => $critere->id,
                            'valeur'        => round(rand(120, 200) / 10, 2), // entre 12 et 20
                            'commentaire'   => null,
                            'valide'        => true,
                            'valide_at'     => now()->subDays(rand(1, 5)),
                        ]);
                    }
                }
            }
        }

        // Mémoire en attente (étudiant sans soutenance planifiée)
        $etudiantsSansSoutenance = $etudiants->whereNotIn(
            'id',
            $etudiantsAvecQuitus->take(8)->pluck('id')
        )->values();

        foreach ($etudiantsSansSoutenance as $etudiant) {
            Memoire::create([
                'etudiant_id'         => $etudiant->id,
                'soutenance_id'       => null,
                'annee_academique_id' => $anneeActiveId,
                'titre'               => 'Analyse de la sécurité des systèmes d\'information en Afrique subsaharienne',
                'resume'              => 'Étude comparative des pratiques de cybersécurité dans les organisations africaines.',
                'fichier_path'        => 'memoires/' . $etudiant->matricule . '_memoire.pdf',
                'taille_fichier_ko'   => rand(1500, 5000),
                'date_depot'          => now()->subDays(rand(1, 10)),
                'statut'              => 'en_attente',
            ]);
        }
    }
}
