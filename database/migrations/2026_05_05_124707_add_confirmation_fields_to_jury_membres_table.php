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
        Schema::table('jury_membres', function (Blueprint $table) {
            $table->enum('statut_confirmation', ['en_attente', 'confirme', 'indisponible'])->default('en_attente');
            $table->text('motif_indisponibilite')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jury_membres', function (Blueprint $table) {
            $table->dropColumn(['statut_confirmation', 'motif_indisponibilite']);
        });
    }
};
