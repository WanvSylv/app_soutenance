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
        Schema::table('memoires', function (Blueprint $table) {
            $table->enum('statut', ['en_attente', 'valide', 'rejete'])->default('en_attente')->after('fichier_path');
            $table->timestamp('valide_at')->nullable()->after('statut');
            $table->foreignId('valide_par')->nullable()->after('valide_at')->constrained('users');
            $table->text('motif_rejet')->nullable()->after('valide_par');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memoires', function (Blueprint $table) {
            $table->dropForeign(['valide_par']);
            $table->dropColumn(['statut', 'valide_at', 'valide_par', 'motif_rejet']);
        });
    }
};
