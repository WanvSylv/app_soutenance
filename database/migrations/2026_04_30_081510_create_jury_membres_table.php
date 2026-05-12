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
        Schema::create('jury_membres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soutenance_id')->constrained('soutenances')->onDelete('cascade');
            $table->foreignId('enseignant_id')->constrained('enseignants')->onDelete('cascade');
            $table->enum('fonction', ['président', 'rapporteur', 'examinateur']);
            $table->boolean('invite_envoye')->default(false);
            $table->timestamp('invite_envoye_at')->nullable();
            $table->timestamps();

            $table->unique(['soutenance_id', 'enseignant_id']);
            $table->unique(['soutenance_id', 'fonction']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jury_membres');
    }
};
