<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL: modify enum to add 'corrections_demandees'
        DB::statement("ALTER TABLE memoires MODIFY COLUMN statut ENUM('en_attente','valide','rejete','corrections_demandees') NOT NULL DEFAULT 'en_attente'");

        Schema::table('memoires', function (Blueprint $table) {
            $table->unsignedSmallInteger('numero_version')->default(1)->after('motif_rejet');
        });
    }

    public function down(): void
    {
        Schema::table('memoires', function (Blueprint $table) {
            $table->dropColumn('numero_version');
        });

        DB::statement("ALTER TABLE memoires MODIFY COLUMN statut ENUM('en_attente','valide','rejete') NOT NULL DEFAULT 'en_attente'");
    }
};
