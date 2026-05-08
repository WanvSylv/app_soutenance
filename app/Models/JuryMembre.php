<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JuryMembre extends Model
{
    protected $table = 'jury_membres';

    protected $fillable = [
        'soutenance_id',
        'enseignant_id',
        'fonction',
        'invite_envoye',
        'invite_envoye_at',
        'statut_confirmation',
        'motif_indisponibilite',
    ];

    public function soutenance()
    {
        return $this->belongsTo(Soutenance::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
}
