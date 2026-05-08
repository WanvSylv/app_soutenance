<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'soutenance_id',
        'enseignant_id',
        'critere_id',
        'valeur',
        'commentaire',
        'valide',
        'valide_at',
    ];

    public function soutenance()
    {
        return $this->belongsTo(Soutenance::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function critere()
    {
        return $this->belongsTo(CritereEvaluation::class, 'critere_id');
    }
}
