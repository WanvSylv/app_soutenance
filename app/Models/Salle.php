<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    protected $fillable = [
        'nom',
        'code',
        'capacite',
        'localisation',
        'equipements',
        'disponible',
    ];

    public function soutenances()
    {
        return $this->hasMany(Soutenance::class);
    }
}
