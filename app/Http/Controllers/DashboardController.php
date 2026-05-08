<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Soutenance;
use App\Models\Salle;
use App\Models\Enseignant;
use App\Models\AnneeAcademique;
use App\Models\ProcesVerbal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // ──────────────────────────────────────────────────────────────
        // TABLEAU DE BORD ENSEIGNANT (JURY)
        // ──────────────────────────────────────────────────────────────
        if ($user->role === 'enseignant') {
            $enseignant = Enseignant::where('user_id', $user->id)->first();

            if (!$enseignant) {
                return view('enseignant.dashboard', ['enseignant' => null]);
            }

            // Soutenances où il est membre du jury
            $soutenancesJury = Soutenance::with(['etudiant.user', 'salle', 'juryMembres'])
                ->whereHas('juryMembres', fn($q) => $q->where('enseignant_id', $enseignant->id))
                ->orderBy('date_heure_debut', 'asc')
                ->get();

            $upcomingSoutenances = $soutenancesJury->filter(
                fn($s) => $s->date_heure_debut >= now() && $s->statut === 'planifiee'
            )->take(5);

            $pendingEvaluationsCount = $soutenancesJury->filter(function ($s) use ($enseignant) {
                return in_array($s->statut, ['planifiee', 'en_cours', 'terminee'])
                    && !$s->notes()->where('enseignant_id', $enseignant->id)->exists();
            })->count();

            $completedEvaluationsCount = $soutenancesJury->filter(function ($s) use ($enseignant) {
                return $s->notes()->where('enseignant_id', $enseignant->id)->exists();
            })->count();

            // Agenda de la semaine courante
            $startOfWeek = now()->startOfWeek();
            $endOfWeek   = now()->endOfWeek();
            $weekSoutenances = $soutenancesJury->filter(
                fn($s) => $s->date_heure_debut->between($startOfWeek, $endOfWeek)
            );
            
            $salles = Salle::all();

            return view('enseignant.dashboard', compact(
                'enseignant',
                'upcomingSoutenances',
                'pendingEvaluationsCount',
                'completedEvaluationsCount',
                'weekSoutenances',
                'startOfWeek'
            ));
        }

        // ──────────────────────────────────────────────────────────────
        // TABLEAU DE BORD ÉTUDIANT
        // ──────────────────────────────────────────────────────────────
        if ($user->role === 'etudiant') {
            $etudiant = Etudiant::where('user_id', $user->id)->first();

            $soutenance = null;
            $procesVerbal = null;
            $memoire = null;

            if ($etudiant) {
                $soutenance = Soutenance::with(['salle', 'juryMembres.enseignant.user', 'procesVerbal'])
                    ->where('etudiant_id', $etudiant->id)
                    ->latest()
                    ->first();

                if ($soutenance) {
                    $procesVerbal = $soutenance->procesVerbal;
                }

                $memoire = $etudiant->memoires()->latest()->first();
            }

            // Pour l'étudiant, on peut aussi montrer le planning global ou filtré
            $startOfWeek = now()->startOfWeek();
            $weekSoutenances = Soutenance::with(['etudiant.user', 'salle'])
                ->whereBetween('date_heure_debut', [now()->startOfWeek(), now()->endOfWeek()])
                ->get();
            $salles = Salle::all();

            return view('etudiant.dashboard', compact(
                'etudiant',
                'soutenance',
                'procesVerbal',
                'memoire',
                'weekSoutenances',
                'startOfWeek',
                'salles'
            ));
        }

        // ──────────────────────────────────────────────────────────────
        // TABLEAU DE BORD ADMINISTRATEUR
        // ──────────────────────────────────────────────────────────────
        $anneeId = $request->input('annee_id');
        $annees = AnneeAcademique::orderBy('libelle', 'desc')->get();
        $anneeActive = AnneeAcademique::where('active', true)->first();
        $anneeFiltre = $anneeId ? $annees->firstWhere('id', $anneeId) : $anneeActive;

        $soutenanceQuery = Soutenance::query();
        if ($anneeFiltre) {
            $soutenanceQuery->where('annee_academique_id', $anneeFiltre->id);
        }

        $stats = [
            'etudiants_count' => Etudiant::count(),
            'soutenances_count' => $soutenanceQuery->count(),
            'salles_count' => Salle::where('disponible', true)->count(),
            'enseignants_count' => Enseignant::count(),
        ];

        $soutenancesTermineesQuery = (clone $soutenanceQuery)->where('statut', 'terminee');
        $totalTerminees = $soutenancesTermineesQuery->count();

        $admis = 0;
        $mentionsCount = [
            'Très Bien' => 0,
            'Bien' => 0,
            'Assez Bien' => 0,
            'Passable' => 0,
            'Ajourné' => 0
        ];

        if ($totalTerminees > 0) {
            $pvs = ProcesVerbal::whereIn('soutenance_id', $soutenancesTermineesQuery->pluck('id'))->get();
            foreach ($pvs as $pv) {
                if (in_array($pv->decision, ['admis', 'félicitations'])) $admis++;
                $mention = array_key_exists($pv->mention, $mentionsCount) ? $pv->mention : 'Ajourné';
                $mentionsCount[$mention]++;
            }
        }

        $tauxReussite = $totalTerminees > 0 ? round(($admis / $totalTerminees) * 100, 1) : 0;

        $upcomingSoutenances = Soutenance::with(['etudiant.user', 'salle'])
            ->where('date_heure_debut', '>=', now())
            ->where('statut', 'planifiee')
            ->orderBy('date_heure_debut', 'asc')
            ->take(6)
            ->get();

        // Alertes : Indisponibilités Jury
        $indisponibilitesJury = \App\Models\JuryMembre::with(['enseignant.user', 'soutenance.etudiant.user'])
            ->where('statut_confirmation', 'indisponible')
            ->whereHas('soutenance', function($q) {
                $q->where('date_heure_debut', '>=', now());
            })->get();

        $availableJury = Enseignant::with('user')->first();
        $conflitsCount = $indisponibilitesJury->count();
        
        // Soutenances passées mais non terminées (Absent ou oubli de note)
        $soutenancesExpirees = Soutenance::with(['etudiant.user', 'salle'])
            ->where('date_heure_fin', '<', now())
            ->where('statut', 'planifiee')
            ->get();
        $soutenancesExpireesCount = $soutenancesExpirees->count();

        $pvAttenteCount = Soutenance::where('statut', 'terminee')
            ->whereDoesntHave('procesVerbal')
            ->count();

        $startOfWeek = now()->startOfWeek();
        $salles = Salle::all();
        $weekSoutenances = Soutenance::with(['etudiant.user', 'salle'])
            ->whereBetween('date_heure_debut', [$startOfWeek, now()->endOfWeek()])
            ->get();

        return view('dashboard', compact(
            'stats', 'annees', 'anneeFiltre', 'tauxReussite', 'mentionsCount',
            'totalTerminees', 'upcomingSoutenances', 'availableJury',
            'conflitsCount', 'pvAttenteCount', 'salles', 'weekSoutenances', 'startOfWeek',
            'indisponibilitesJury', 'soutenancesExpirees', 'soutenancesExpireesCount'
        ));
    }
}
