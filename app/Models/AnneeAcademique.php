<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnneeAcademique extends Model
{
    protected $table = 'annees_academiques';

    protected $fillable = [
        'libelle',
        'date_debut',
        'date_fin',
        'active',
    ];

    public function soutenances()
    {
        return $this->hasMany(Soutenance::class);
    }

    public function memoires()
    {
        return $this->hasMany(Memoire::class);
    }
}
