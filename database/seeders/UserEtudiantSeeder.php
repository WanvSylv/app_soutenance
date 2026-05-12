<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Etudiant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserEtudiantSeeder extends Seeder
{
    public function run(): void
    {
        $etudiants = [
            ['nom' => 'AGBOSSOU',   'prenom' => 'Kévin',    'email' => 'k.agbossou@etud.univ.bj',   'matricule' => 'ETU2025001', 'filiere' => 'Génie Informatique',           'niveau' => 'Licence 3', 'quitus' => true],
            ['nom' => 'BIAOU',      'prenom' => 'Mireille',  'email' => 'm.biaou@etud.univ.bj',      'matricule' => 'ETU2025002', 'filiere' => 'Génie Informatique',           'niveau' => 'Licence 3', 'quitus' => true],
            ['nom' => 'CHABI',      'prenom' => 'Ibrahim',   'email' => 'i.chabi@etud.univ.bj',      'matricule' => 'ETU2025003', 'filiere' => 'Réseaux & Télécommunications', 'niveau' => 'Licence 3', 'quitus' => true],
            ['nom' => 'DOSSA',      'prenom' => 'Clarisse',  'email' => 'c.dossa@etud.univ.bj',      'matricule' => 'ETU2025004', 'filiere' => 'Génie Informatique',           'niveau' => 'Master 1',  'quitus' => true],
            ['nom' => 'ELEGBE',     'prenom' => 'Patrick',   'email' => 'p.elegbe@etud.univ.bj',     'matricule' => 'ETU2025005', 'filiere' => 'Systèmes d\'Information',      'niveau' => 'Master 1',  'quitus' => true],
            ['nom' => 'FANOU',      'prenom' => 'Sandrine',  'email' => 's.fanou@etud.univ.bj',      'matricule' => 'ETU2025006', 'filiere' => 'Génie Informatique',           'niveau' => 'Master 2',  'quitus' => true],
            ['nom' => 'GNONLONFIN', 'prenom' => 'Martial',   'email' => 'm.gnonlonfin@etud.univ.bj', 'matricule' => 'ETU2025007', 'filiere' => 'Intelligence Artificielle',    'niveau' => 'Master 2',  'quitus' => false],
            ['nom' => 'HOUNSOU',    'prenom' => 'Aurore',    'email' => 'a.hounsou@etud.univ.bj',    'matricule' => 'ETU2025008', 'filiere' => 'Réseaux & Télécommunications', 'niveau' => 'Licence 3', 'quitus' => true],
            ['nom' => 'AZONDEKON', 'prenom' => 'Joël',      'email' => 'j.azondekon@etud.univ.bj',  'matricule' => 'ETU2025009', 'filiere' => 'Systèmes d\'Information',      'niveau' => 'Master 1',  'quitus' => true],
            ['nom' => 'KAKPO',      'prenom' => 'Nathalie',  'email' => 'n.kakpo@etud.univ.bj',      'matricule' => 'ETU2025010', 'filiere' => 'Génie Informatique',           'niveau' => 'Master 2',  'quitus' => false],
        ];

        // L'admin (id=1) validera les quitus
        $adminId = 1;

        foreach ($etudiants as $data) {
            $user = User::create([
                'nom'              => $data['nom'],
                'prenom'           => $data['prenom'],
                'email'            => $data['email'],
                'password'         => Hash::make('password'),
                'role'             => 'etudiant',
                'actif'            => true,
                'email_verified_at' => now(),
            ]);

            Etudiant::create([
                'user_id'           => $user->id,
                'matricule'         => $data['matricule'],
                'filiere'           => $data['filiere'],
                'niveau'            => $data['niveau'],
                'annee_inscription' => 2025,
                'quitus_valide'     => $data['quitus'],
                'quitus_valide_at'  => $data['quitus'] ? now()->subDays(rand(10, 60)) : null,
                'quitus_valide_par' => $data['quitus'] ? $adminId : null,
            ]);
        }
    }
}
