<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $fillable = [
        'user_id',
        'matricule',
        'filiere',
        'niveau',
        'annee_inscription',
        'quitus_valide',
        'quitus_valide_at',
        'quitus_valide_par',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'quitus_valide_par');
    }

    public function soutenances()
    {
        return $this->hasMany(Soutenance::class);
    }

    public function memoires()
    {
        return $this->hasMany(Memoire::class);
    }
}
