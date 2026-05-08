<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('soutenance_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type_notification'); // convocation, resultat
            $table->text('contenu')->nullable();
            $table->string('statut')->default('en_attente'); // envoye, erreur, en_attente
            $table->timestamp('date_envoi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_emails');
    }
};
