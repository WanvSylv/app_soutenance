<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memoire extends Model
{
    protected $casts = [
        'date_depot' => 'datetime',
        'valide_at'  => 'datetime',
    ];

    protected $fillable = [
        'etudiant_id',
        'soutenance_id',
        'annee_academique_id',
        'titre',
        'resume',
        'fichier_path',
        'taille_fichier_ko',
        'date_depot',
        'statut',
        'valide_at',
        'valide_par',
        'motif_rejet',
        'numero_version',
    ];

    public function validator()
    {
        return $this->belongsTo(User::class, 'valide_par');
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function soutenance()
    {
        return $this->belongsTo(Soutenance::class);
    }

    public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class);
    }

    public function versions()
    {
        return $this->hasMany(MemoireVersion::class)->orderBy('numero_version');
    }

    public function isResoumettable(): bool
    {
        return in_array($this->statut, ['corrections_demandees', 'rejete']);
    }
}
