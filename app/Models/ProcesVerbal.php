<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcesVerbal extends Model
{
    protected $table = 'proces_verbaux';

    protected $fillable = [
        'soutenance_id',
        'note_finale',
        'mention',
        'decision',
        'observations',
        'fichier_pdf_path',
        'genere_at',
        'valide_par',
        'valide_at',
        'resultats_publies',
        'resultats_publies_at',
    ];

    public function soutenance()
    {
        return $this->belongsTo(Soutenance::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'valide_par');
    }
}
