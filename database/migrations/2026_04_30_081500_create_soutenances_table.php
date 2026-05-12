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
        Schema::create('soutenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('annee_academique_id')->constrained('annees_academiques');
            $table->foreignId('salle_id')->constrained('salles');
            $table->text('sujet');
            $table->dateTime('date_heure_debut');
            $table->dateTime('date_heure_fin');
            $table->enum('statut', ['planifiee', 'en_cours', 'terminee', 'annulee', 'deliberee'])->default('planifiee');
            $table->boolean('convocations_envoyees')->default(false);
            $table->timestamp('convocations_envoyees_at')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soutenances');
    }
};
