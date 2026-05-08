<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisponibiliteEnseignant extends Model
{
    protected $table = 'disponibilites_enseignants';

    protected $fillable = [
        'enseignant_id',
        'date',
        'heure_debut',
        'heure_fin',
        'motif',
    ];

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
}
