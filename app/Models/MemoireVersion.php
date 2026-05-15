<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemoireVersion extends Model
{
    protected $casts = [
        'date_depot' => 'datetime',
        'traite_at'  => 'datetime',
    ];

    protected $fillable = [
        'memoire_id',
        'numero_version',
        'titre',
        'resume',
        'fichier_path',
        'taille_fichier_ko',
        'date_depot',
        'statut_apres',
        'motif',
        'traite_par',
        'traite_at',
    ];

    public function memoire()
    {
        return $this->belongsTo(Memoire::class);
    }

    public function traitePar()
    {
        return $this->belongsTo(User::class, 'traite_par');
    }
}
