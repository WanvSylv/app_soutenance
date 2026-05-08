<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationEmail extends Model
{
    protected $table = 'notification_emails';

    protected $fillable = [
        'user_id',
        'soutenance_id',
        'type_notification',
        'contenu',
        'statut',
        'date_envoi',
    ];

    public function soutenance()
    {
        return $this->belongsTo(Soutenance::class);
    }
}
