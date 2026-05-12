<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Nettoyage préalable des données orphelines pour éviter les erreurs lors de l'ajout des contraintes
        $this->cleanupOrphans();

        // Soutenances
        Schema::table('soutenances', function (Blueprint $table) {
            $table->dropForeign(['annee_academique_id']);
            $table->dropForeign(['salle_id']);
            $table->dropForeign(['created_by']);

            $table->foreign('annee_academique_id')->references('id')->on('annees_academiques')->onDelete('cascade');
            $table->foreign('salle_id')->references('id')->on('salles')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });

        // Memoires
        Schema::table('memoires', function (Blueprint $table) {
            $table->dropForeign(['soutenance_id']);
            $table->dropForeign(['annee_academique_id']);

            $table->foreign('soutenance_id')->references('id')->on('soutenances')->onDelete('set null');
            $table->foreign('annee_academique_id')->references('id')->on('annees_academiques')->onDelete('cascade');
        });

        // Notes
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign(['critere_id']);
            $table->foreign('critere_id')->references('id')->on('criteres_evaluation')->onDelete('cascade');
        });

        // Etudiants (Quitus par)
        Schema::table('etudiants', function (Blueprint $table) {
            $table->dropForeign(['quitus_valide_par']);
            $table->foreign('quitus_valide_par')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original state if needed
    }

    private function cleanupOrphans(): void
    {
        // Supprimer les étudiants dont l'utilisateur n'existe plus
        DB::table('etudiants')->whereNotExists(function ($query) {
            $query->select(DB::raw(1))->from('users')->whereRaw('users.id = etudiants.user_id');
        })->delete();

        // Supprimer les enseignants dont l'utilisateur n'existe plus
        DB::table('enseignants')->whereNotExists(function ($query) {
            $query->select(DB::raw(1))->from('users')->whereRaw('users.id = enseignants.user_id');
        })->delete();

        // Supprimer les soutenances dont l'étudiant, la salle ou l'année n'existe plus
        DB::table('soutenances')->whereNotExists(function ($query) {
            $query->select(DB::raw(1))->from('etudiants')->whereRaw('etudiants.id = soutenances.etudiant_id');
        })->orWhereNotExists(function ($query) {
            $query->select(DB::raw(1))->from('salles')->whereRaw('salles.id = soutenances.salle_id');
        })->orWhereNotExists(function ($query) {
            $query->select(DB::raw(1))->from('annees_academiques')->whereRaw('annees_academiques.id = soutenances.annee_academique_id');
        })->delete();

        // Nettoyer jury_membres
        DB::table('jury_membres')->whereNotExists(function ($query) {
            $query->select(DB::raw(1))->from('soutenances')->whereRaw('soutenances.id = jury_membres.soutenance_id');
        })->orWhereNotExists(function ($query) {
            $query->select(DB::raw(1))->from('enseignants')->whereRaw('enseignants.id = jury_membres.enseignant_id');
        })->delete();

        // Nettoyer memoires
        DB::table('memoires')->whereNotExists(function ($query) {
            $query->select(DB::raw(1))->from('etudiants')->whereRaw('etudiants.id = memoires.etudiant_id');
        })->delete();
        
        // Mettre à null les soutenance_id inexistants dans memoires
        DB::table('memoires')->whereNotNull('soutenance_id')->whereNotExists(function ($query) {
            $query->select(DB::raw(1))->from('soutenances')->whereRaw('soutenances.id = memoires.soutenance_id');
        })->update(['soutenance_id' => null]);
    }
};
