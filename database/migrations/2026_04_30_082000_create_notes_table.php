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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soutenance_id')->constrained('soutenances')->onDelete('cascade');
            $table->foreignId('enseignant_id')->constrained('enseignants')->onDelete('cascade');
            $table->foreignId('critere_id')->constrained('criteres_evaluation');
            $table->decimal('valeur', 4, 2);
            $table->text('commentaire')->nullable();
            $table->boolean('valide')->default(false);
            $table->timestamp('valide_at')->nullable();
            $table->timestamps();

            $table->unique(['soutenance_id', 'enseignant_id', 'critere_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
