<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memoire_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memoire_id')->constrained('memoires')->cascadeOnDelete();
            $table->unsignedSmallInteger('numero_version');
            $table->string('titre', 500);
            $table->text('resume')->nullable();
            $table->string('fichier_path');
            $table->unsignedInteger('taille_fichier_ko');
            $table->timestamp('date_depot');
            $table->enum('statut_apres', ['en_attente', 'valide', 'rejete', 'corrections_demandees'])->nullable()
                  ->comment('Statut attribué à cette version lors du traitement');
            $table->text('motif')->nullable()->comment('Motif rejet ou corrections demandées');
            $table->foreignId('traite_par')->nullable()->constrained('users');
            $table->timestamp('traite_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memoire_versions');
    }
};
