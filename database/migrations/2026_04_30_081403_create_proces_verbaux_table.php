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
        Schema::create('proces_verbaux', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soutenance_id')->unique()->constrained('soutenances')->onDelete('cascade');
            $table->decimal('note_finale', 4, 2);
            $table->string('mention', 50);
            $table->enum('decision', ['admis', 'ajourne', 'félicitations']);
            $table->text('observations')->nullable();
            $table->string('fichier_pdf_path')->nullable();
            $table->timestamp('genere_at')->nullable();
            $table->foreignId('valide_par')->nullable()->constrained('users');
            $table->timestamp('valide_at')->nullable();
            $table->boolean('resultats_publies')->default(false);
            $table->timestamp('resultats_publies_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proces_verbaux');
    }
};
