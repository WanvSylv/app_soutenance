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
        Schema::create('memoires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('soutenance_id')->nullable()->constrained('soutenances');
            $table->foreignId('annee_academique_id')->constrained('annees_academiques');
            $table->string('titre', 500);
            $table->text('resume')->nullable();
            $table->string('fichier_path');
            $table->unsignedInteger('taille_fichier_ko');
            $table->timestamp('date_depot');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memoires');
    }
};
