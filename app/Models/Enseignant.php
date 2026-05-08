<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    protected $fillable = [
        'user_id',
        'grade',
        'specialite',
        'departement',
        'bureau',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function juryMembres()
    {
        return $this->hasMany(JuryMembre::class);
    }

    public function disponibilites()
    {
        return $this->hasMany(DisponibiliteEnseignant::class);
    }
}
