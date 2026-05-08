<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications_email', function (Blueprint $table) {
            $table->id();
            $table->string('destinataire_email');
            $table->string('destinataire_nom');
            $table->enum('type', ['convocation', 'rappel', 'resultat', 'pv', 'identifiants', 'verification']);
            $table->string('objet');
            $table->foreignId('soutenance_id')->nullable()->constrained('soutenances');
            $table->enum('statut', ['en_attente', 'envoye', 'echec'])->default('en_attente');
            $table->timestamp('envoye_at')->nullable();
            $table->text('erreur_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications_email');
    }
};
