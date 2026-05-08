<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Parametre;
use App\Models\CritereEvaluation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création du Super Admin
        User::create([
            'nom' => 'Administrateur',
            'prenom' => 'HOREB',
            'email' => 'admin@horebip.com',
            'password' => Hash::make('admin1234'),
            'role' => 'super_admin',
            'actif' => true,
            'email_verified_at' => now(),
        ]);

        // Paramètres par défaut
        $params = [
            ['cle' => 'duree_soutenance_min', 'valeur' => '60', 'description' => 'Durée par défaut d\'une soutenance en minutes'],
            ['cle' => 'nb_membres_jury', 'valeur' => '3', 'description' => 'Nombre obligatoire de membres par jury'],
            ['cle' => 'note_passage', 'valeur' => '10', 'description' => 'Note minimale pour valider la soutenance'],
            ['cle' => 'taille_max_memoire_mb', 'valeur' => '50', 'description' => 'Taille maximale du fichier mémoire (MB)'],
            ['cle' => 'email_noreply', 'valeur' => 'contact@horebip.com', 'description' => 'Email expéditeur des notifications'],
            ['cle' => 'felicitations_note', 'valeur' => '16', 'description' => 'Note minimale pour obtenir les félicitations'],
        ];

        foreach ($params as $param) {
            Parametre::create($param);
        }

        // Critères d'évaluation par défaut
        $criteria = [
            ['libelle' => 'Qualité du fond (Manuscrit)', 'coefficient' => 1.0, 'description' => 'Évaluation de la structure, du contenu et de la rigueur scientifique.', 'ordre' => 1],
            ['libelle' => 'Présentation orale', 'coefficient' => 0.5, 'description' => 'Évaluation de l\'aisance, du support et de la clarté.', 'ordre' => 2],
            ['libelle' => 'Réponse aux questions', 'coefficient' => 0.5, 'description' => 'Évaluation de la maîtrise du sujet face au jury.', 'ordre' => 3],
        ];

        foreach ($criteria as $criterion) {
            CritereEvaluation::create($criterion);
        }
    }
}
