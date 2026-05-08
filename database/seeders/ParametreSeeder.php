<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parametre;

class ParametreSeeder extends Seeder
{
    public function run(): void
    {
        $parametres = [
            [
                'cle'         => 'duree_soutenance',
                'valeur'      => '90',
                'description' => 'Durée standard d\'une soutenance (en minutes)',
            ],
            [
                'cle'         => 'taille_max_memoire_mo',
                'valeur'      => '30',
                'description' => 'Taille maximale autorisée pour le dépôt de mémoire (en Mo)',
            ],
            [
                'cle'         => 'note_passage',
                'valeur'      => '10',
                'description' => 'Note minimale pour valider une soutenance (/20)',
            ],
            [
                'cle'         => 'delai_convocation_j',
                'valeur'      => '7',
                'description' => 'Délai minimum d\'envoi des convocations avant la soutenance (en jours)',
            ],
            [
                'cle'         => 'email_contact',
                'valeur'      => 'contact@horebip.edu',
                'description' => 'Adresse email de contact de l\'administration',
            ],
            [
                'cle'         => 'nom_institution',
                'valeur'      => 'HOREB IP',
                'description' => 'Nom officiel de l\'institution',
            ],
            [
                'cle'         => 'ville_institution',
                'valeur'      => 'Cotonou',
                'description' => 'Ville de l\'institution',
            ],
        ];

        foreach ($parametres as $parametre) {
            Parametre::updateOrCreate(['cle' => $parametre['cle']], $parametre);
        }
    }
}
