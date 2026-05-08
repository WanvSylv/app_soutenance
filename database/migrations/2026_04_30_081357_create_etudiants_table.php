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
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('matricule', 50)->unique();
            $table->string('filiere', 150);
            $table->string('niveau', 20);
            $table->year('annee_inscription');
            $table->boolean('quitus_valide')->default(false);
            $table->timestamp('quitus_valide_at')->nullable();
            $table->foreignId('quitus_valide_par')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
