<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CritereEvaluation extends Model
{
    protected $table = 'criteres_evaluation';

    protected $fillable = [
        'libelle',
        'coefficient',
        'description',
        'actif',
        'ordre',
    ];

    public function notes()
    {
        return $this->hasMany(Note::class, 'critere_id');
    }
}
