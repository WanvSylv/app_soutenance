<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memoire extends Model
{
    protected $fillable = [
        'etudiant_id',
        'soutenance_id',
        'annee_academique_id',
        'titre',
        'resume',
        'fichier_path',
        'taille_fichier_ko',
        'date_depot',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function soutenance()
    {
        return $this->belongsTo(Soutenance::class);
    }

    public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class);
    }
}
