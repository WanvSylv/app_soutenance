<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Enseignant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserEnseignantSeeder extends Seeder
{
    public function run(): void
    {
        $enseignants = [
            [
                'user' => [
                    'nom' => 'AHOUNOU',
                    'prenom' => 'Kofi',
                    'email' => 'k.ahounou@univ.bj',
                    'password' => Hash::make('password'),
                    'role' => 'enseignant',
                    'telephone' => '+22997000001',
                    'actif' => true,
                    'email_verified_at' => now(),
                ],
                'profil' => [
                    'grade' => 'Maître de Conférences',
                    'specialite' => 'Génie Logiciel',
                    'departement' => 'Informatique',
                    'bureau' => 'B204',
                ],
            ],
            [
                'user' => [
                    'nom' => 'DOSSOU',
                    'prenom' => 'Adjoa',
                    'email' => 'a.dossou@univ.bj',
                    'password' => Hash::make('password'),
                    'role' => 'enseignant',
                    'telephone' => '+22997000002',
                    'actif' => true,
                    'email_verified_at' => now(),
                ],
                'profil' => [
                    'grade' => 'Professeur Titulaire',
                    'specialite' => 'Réseaux et Télécommunications',
                    'departement' => 'Informatique',
                    'bureau' => 'B105',
                ],
            ],
            [
                'user' => [
                    'nom' => 'HOUNWANOU',
                    'prenom' => 'Sèmèvo',
                    'email' => 's.hounwanou@univ.bj',
                    'password' => Hash::make('password'),
                    'role' => 'enseignant',
                    'telephone' => '+22997000003',
                    'actif' => true,
                    'email_verified_at' => now(),
                ],
                'profil' => [
                    'grade' => 'Maître-Assistant',
                    'specialite' => 'Intelligence Artificielle',
                    'departement' => 'Informatique',
                    'bureau' => 'B310',
                ],
            ],
            [
                'user' => [
                    'nom' => 'VODOUNOU',
                    'prenom' => 'Agnès',
                    'email' => 'a.vodounou@univ.bj',
                    'password' => Hash::make('password'),
                    'role' => 'enseignant',
                    'telephone' => '+22997000004',
                    'actif' => true,
                    'email_verified_at' => now(),
                ],
                'profil' => [
                    'grade' => 'Maître de Conférences',
                    'specialite' => 'Base de Données',
                    'departement' => 'Informatique',
                    'bureau' => 'B206',
                ],
            ],
            [
                'user' => [
                    'nom' => 'GBEDJI',
                    'prenom' => 'Romuald',
                    'email' => 'r.gbedji@univ.bj',
                    'password' => Hash::make('password'),
                    'role' => 'enseignant',
                    'telephone' => '+22997000005',
                    'actif' => true,
                    'email_verified_at' => now(),
                ],
                'profil' => [
                    'grade' => 'Maître-Assistant',
                    'specialite' => 'Systèmes Embarqués',
                    'departement' => 'Electronique',
                    'bureau' => 'C102',
                ],
            ],
            [
                'user' => [
                    'nom' => 'AKPOVI',
                    'prenom' => 'Blandine',
                    'email' => 'b.akpovi@univ.bj',
                    'password' => Hash::make('password'),
                    'role' => 'enseignant',
                    'telephone' => '+22997000006',
                    'actif' => true,
                    'email_verified_at' => now(),
                ],
                'profil' => [
                    'grade' => 'Professeur Titulaire',
                    'specialite' => 'Cybersécurité',
                    'departement' => 'Informatique',
                    'bureau' => 'B401',
                ],
            ],
        ];

        foreach ($enseignants as $data) {
            $user = User::create($data['user']);
            Enseignant::create(array_merge($data['profil'], ['user_id' => $user->id]));
        }
    }
}
