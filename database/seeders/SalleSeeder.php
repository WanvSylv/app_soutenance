<?php

namespace Database\Seeders;

use App\Models\Salle;
use Illuminate\Database\Seeder;

class SalleSeeder extends Seeder
{
    public function run(): void
    {
        $salles = [
            ['nom' => 'Salle de Conférence A', 'code' => 'CONF-A', 'capacite' => 30, 'localisation' => 'Bâtiment Principal - RDC', 'equipements' => 'Vidéoprojecteur, Tableau blanc, Climatisation', 'disponible' => true],
            ['nom' => 'Salle de Conférence B', 'code' => 'CONF-B', 'capacite' => 20, 'localisation' => 'Bâtiment Principal - 1er étage', 'equipements' => 'Vidéoprojecteur, Tableau blanc', 'disponible' => true],
            ['nom' => 'Amphithéâtre 1',        'code' => 'AMPHI-1', 'capacite' => 100, 'localisation' => 'Bâtiment Pédagogique', 'equipements' => 'Grand écran, Micro, Climatisation', 'disponible' => true],
            ['nom' => 'Salle Informatique',    'code' => 'INFO-01', 'capacite' => 25, 'localisation' => 'Bâtiment Informatique - RDC', 'equipements' => '25 postes PC, Vidéoprojecteur', 'disponible' => true],
            ['nom' => 'Salle de Réunion',      'code' => 'REUN-01', 'capacite' => 10, 'localisation' => 'Bâtiment Administration', 'equipements' => 'Tableau blanc, TV 55 pouces', 'disponible' => true],
        ];

        foreach ($salles as $salle) {
            Salle::create($salle);
        }
    }
}
