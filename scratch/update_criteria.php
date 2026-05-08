<?php

use App\Models\CritereEvaluation;

$criteria = [
    ['libelle' => 'Pertinence et qualité du sujet', 'coefficient' => 2, 'ordre' => 1],
    ['libelle' => 'Maitrise du contenu', 'coefficient' => 3, 'ordre' => 2],
    ['libelle' => 'Méthodologie et démarche', 'coefficient' => 2, 'ordre' => 3],
    ['libelle' => 'Conception et réalisation', 'coefficient' => 3, 'ordre' => 4],
    ['libelle' => 'Présentation et communication', 'coefficient' => 2, 'ordre' => 5],
    ['libelle' => 'Réponses aux questions', 'coefficient' => 1, 'ordre' => 6],
];

// Désactiver les anciens
CritereEvaluation::query()->update(['actif' => false]);

foreach ($criteria as $c) {
    CritereEvaluation::updateOrCreate(
        ['libelle' => $c['libelle']],
        ['coefficient' => $c['coefficient'], 'ordre' => $c['ordre'], 'actif' => true]
    );
}

echo "Critères mis à jour avec succès.";
