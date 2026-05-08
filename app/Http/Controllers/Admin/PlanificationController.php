<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soutenance;
use App\Models\Etudiant;
use App\Models\Salle;
use App\Models\Enseignant;
use App\Models\AnneeAcademique;
use App\Models\JuryMembre;
use App\Models\Memoire;
use App\Models\DisponibiliteEnseignant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlanificationController extends Controller
{
    public function index(Request $request)
    {
        $view = $request->input('view', 'week'); // 'day', 'week', 'month'
        $dateRef = $request->filled('date') ? Carbon::parse($request->date) : now();
        
        $start = $dateRef->copy();
        $end = $dateRef->copy();

        if ($view === 'day') {
            $start = $dateRef->copy()->startOfDay();
            $end = $dateRef->copy()->endOfDay();
        } elseif ($view === 'month') {
            $start = $dateRef->copy()->startOfMonth()->startOfWeek();
            $end = $dateRef->copy()->endOfMonth()->endOfWeek();
        } else {
            // Week
            $start = $dateRef->copy()->startOfWeek();
            $end = $dateRef->copy()->endOfWeek();
        }

        $query = Soutenance::with(['etudiant.user', 'salle', 'anneeAcademique', 'juryMembres.enseignant.user'])
            ->whereBetween('date_heure_debut', [$start, $end]);

        // Role-based filtering
        $user = auth()->user();
        if ($user->role === 'enseignant') {
            $enseignant = \App\Models\Enseignant::where('user_id', $user->id)->first();
            if ($enseignant) {
                $query->whereHas('juryMembres', function($q) use ($enseignant) {
                    $q->where('enseignant_id', $enseignant->id);
                });
            }
        } elseif ($user->role === 'etudiant') {
            $etudiant = \App\Models\Etudiant::where('user_id', $user->id)->first();
            if ($etudiant) {
                $query->where('etudiant_id', $etudiant->id);
            }
        }

        // Filtres manuels (Selects)
        if ($request->filled('salle_id') && $request->salle_id != 'all') {
            $query->where('salle_id', $request->salle_id);
        }

        if ($request->filled('enseignant_id')) {
            $query->whereHas('juryMembres', function($q) use ($request) {
                $q->where('enseignant_id', $request->enseignant_id);
            });
        }

        $soutenances = $query->get();
        
        // Si une salle est sélectionnée, on ne montre que celle-là dans la grille
        if ($request->filled('salle_id') && $request->salle_id != 'all') {
            $salles = Salle::where('id', $request->salle_id)->get();
        } else {
            $salles = Salle::all();
        }

        $enseignants = Enseignant::with('user')->get();
        
        $user = auth()->user();
        $nextSoutenance = null;
        if ($user->role === 'enseignant') {
            $availableJury = Enseignant::with('user')->where('user_id', $user->id)->first();
            if ($availableJury) {
                $nextSoutenance = Soutenance::whereHas('juryMembres', function($q) use ($availableJury) {
                    $q->where('enseignant_id', $availableJury->id);
                })
                ->where('date_heure_debut', '>=', now())
                ->with(['etudiant.user', 'salle', 'juryMembres.enseignant.user'])
                ->orderBy('date_heure_debut', 'asc')
                ->first();
            }
        } elseif ($user->role === 'etudiant') {
            $availableJury = null; 
        } else {
            $availableJury = Enseignant::with('user')->whereHas('user', function($q) {
                $q->whereNotNull('photo_path');
            })->first() ?? $enseignants->first();
        }

        return view('admin.planification.index', compact(
            'soutenances', 
            'salles', 
            'enseignants', 
            'start', 
            'end',
            'availableJury',
            'view',
            'nextSoutenance'
        ));
    }

    public function create()
    {
        $anneeActive = AnneeAcademique::where('active', true)->first();
        
        if (!$anneeActive) {
            return redirect()->route('admin.annees-academiques.index')->with('error', "Veuillez activer une année académique avant de planifier.");
        }

        $etudiants = Etudiant::where('quitus_valide', true)
            ->whereHas('memoires', function($q) use ($anneeActive) {
                $q->where('annee_academique_id', $anneeActive->id);
            })
            ->whereDoesntHave('soutenances', function($q) use ($anneeActive) {
                $q->where('annee_academique_id', $anneeActive->id);
            })
            ->with('user')
            ->get();

        $salles = Salle::where('disponible', true)->get();
        $enseignants = Enseignant::with('user')->get();

        return view('admin.planification.create', compact('etudiants', 'salles', 'enseignants', 'anneeActive'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'salle_id' => 'required|exists:salles,id',
            'sujet' => 'required|string|max:500',
            'date_soutenance' => 'required|date|after:today',
            'heure_debut' => 'required',
            'president_id' => 'required|exists:enseignants,id',
            'rapporteur_id' => 'required|exists:enseignants,id|different:president_id',
            'membre_id' => 'nullable|exists:enseignants,id|different:president_id|different:rapporteur_id',
        ]);

        $anneeActive = AnneeAcademique::where('active', true)->first();
        $start = Carbon::parse($request->date_soutenance . ' ' . $request->heure_debut);
        $end = (clone $start)->addMinutes(90);

        // Conflit Salle
        $conflitSalle = Soutenance::where('salle_id', $request->salle_id)
            ->where(function($q) use ($start, $end) {
                $q->whereBetween('date_heure_debut', [$start, $end])
                  ->orWhereBetween('date_heure_fin', [$start, $end])
                  ->orWhere(function($sq) use ($start, $end) {
                      $sq->where('date_heure_debut', '<=', $start)
                        ->where('date_heure_fin', '>=', $end);
                  });
            })->exists();

        if ($conflitSalle) {
            return back()->withInput()->with('error', "La salle est déjà occupée sur ce créneau.");
        }

        // Conflit Jury
        $juryIds = array_filter([$request->president_id, $request->rapporteur_id, $request->membre_id]);
        
        $conflitJury = JuryMembre::whereIn('enseignant_id', $juryIds)
            ->whereHas('soutenance', function($q) use ($start, $end) {
                $q->where(function($sq) use ($start, $end) {
                    $sq->whereBetween('date_heure_debut', [$start, $end])
                      ->orWhereBetween('date_heure_fin', [$start, $end]);
                });
            })->exists();

        if ($conflitJury) {
            return back()->withInput()->with('error', "Un ou plusieurs membres du jury sont déjà mobilisés sur ce créneau.");
        }

        // Vérification des indisponibilités (DisponibiliteEnseignant avec motif)
        $indisponibilites = DisponibiliteEnseignant::whereIn('enseignant_id', $juryIds)
            ->where('date', $request->date_soutenance)
            ->where(function($q) use ($request) {
                $q->whereBetween('heure_debut', [$request->heure_debut, Carbon::parse($request->heure_debut)->addMinutes(90)->format('H:i')])
                  ->orWhereBetween('heure_fin', [$request->heure_debut, Carbon::parse($request->heure_debut)->addMinutes(90)->format('H:i')]);
            })->exists();

        if ($indisponibilites) {
            return back()->withInput()->with('error', "Un ou plusieurs membres du jury ont déclaré une indisponibilité sur ce créneau.");
        }

        DB::transaction(function() use ($request, $anneeActive, $juryIds, $start, $end) {
            $soutenance = Soutenance::create([
                'etudiant_id' => $request->etudiant_id,
                'salle_id' => $request->salle_id,
                'annee_academique_id' => $anneeActive->id,
                'sujet' => $request->sujet,
                'date_heure_debut' => $start,
                'date_heure_fin' => $end,
                'statut' => 'planifiee',
                'created_by' => auth()->id(),
            ]);

            foreach ($juryIds as $enseignantId) {
                $fonction = 'examinateur';
                if ($enseignantId == $request->president_id) $fonction = 'président';
                elseif ($enseignantId == $request->rapporteur_id) $fonction = 'rapporteur';

                JuryMembre::create([
                    'soutenance_id' => $soutenance->id,
                    'enseignant_id' => $enseignantId,
                    'fonction' => $fonction,
                ]);
            }

            // Notification
            $soutenance->notifyStudent('convocation');
        });

        return redirect()->route('planification.index')->with('success', "La soutenance a été planifiée et les convocations ont été envoyées avec succès.");
    }

    public function edit($id)
    {
        $soutenance = Soutenance::with(['juryMembres', 'etudiant.user'])->findOrFail($id);
        $anneeActive = AnneeAcademique::where('active', true)->first();
        
        $etudiants = Etudiant::where('quitus_valide', true)->with('user')->get();
        $salles = Salle::where('disponible', true)->orWhere('id', $soutenance->salle_id)->get();
        $enseignants = Enseignant::with('user')->get();

        $president = $soutenance->juryMembres->where('fonction', 'président')->first();
        $rapporteur = $soutenance->juryMembres->where('fonction', 'rapporteur')->first();
        $membre = $soutenance->juryMembres->where('fonction', 'examinateur')->first();

        return view('admin.planification.edit', compact('soutenance', 'etudiants', 'salles', 'enseignants', 'anneeActive', 'president', 'rapporteur', 'membre'));
    }

    public function update(Request $request, $id)
    {
        $soutenance = Soutenance::findOrFail($id);

        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'salle_id' => 'required|exists:salles,id',
            'sujet' => 'required|string|max:500',
            'date_soutenance' => 'required|date',
            'heure_debut' => 'required',
            'president_id' => 'required|exists:enseignants,id',
            'rapporteur_id' => 'required|exists:enseignants,id|different:president_id',
            'membre_id' => 'nullable|exists:enseignants,id|different:president_id|different:rapporteur_id',
        ]);

        $start = Carbon::parse($request->date_soutenance . ' ' . $request->heure_debut);
        $end = (clone $start)->addMinutes(90);

        // Conflit Salle (en ignorant la soutenance actuelle)
        $conflitSalle = Soutenance::where('salle_id', $request->salle_id)
            ->where('id', '!=', $id)
            ->where(function($q) use ($start, $end) {
                $q->whereBetween('date_heure_debut', [$start, $end])
                  ->orWhereBetween('date_heure_fin', [$start, $end]);
            })->exists();

        if ($conflitSalle) {
            return back()->withInput()->with('error', "La salle est déjà occupée sur ce créneau.");
        }

        $juryIds = array_filter([$request->president_id, $request->rapporteur_id, $request->membre_id]);

        // Conflit Jury (en ignorant la soutenance actuelle)
        $conflitJury = JuryMembre::whereIn('enseignant_id', $juryIds)
            ->where('soutenance_id', '!=', $id)
            ->whereHas('soutenance', function($q) use ($start, $end) {
                $q->where(function($sq) use ($start, $end) {
                    $sq->whereBetween('date_heure_debut', [$start, $end])
                      ->orWhereBetween('date_heure_fin', [$start, $end]);
                });
            })->exists();

        if ($conflitJury) {
            return back()->withInput()->with('error', "Un ou plusieurs membres du jury sont déjà mobilisés sur ce créneau.");
        }

        // Vérification des indisponibilités
        $indisponibilites = DisponibiliteEnseignant::whereIn('enseignant_id', $juryIds)
            ->where('date', $request->date_soutenance)
            ->where(function($q) use ($request) {
                $q->whereBetween('heure_debut', [$request->heure_debut, Carbon::parse($request->heure_debut)->addMinutes(90)->format('H:i')])
                  ->orWhereBetween('heure_fin', [$request->heure_debut, Carbon::parse($request->heure_debut)->addMinutes(90)->format('H:i')]);
            })->exists();

        if ($indisponibilites) {
            return back()->withInput()->with('error', "Un ou plusieurs membres du jury ont déclaré une indisponibilité sur ce créneau.");
        }

        DB::transaction(function() use ($request, $soutenance, $juryIds, $start, $end) {
            $soutenance->update([
                'etudiant_id' => $request->etudiant_id,
                'salle_id' => $request->salle_id,
                'sujet' => $request->sujet,
                'date_heure_debut' => $start,
                'date_heure_fin' => $end,
            ]);

            // Mise à jour du jury : on supprime et on recrée (plus simple)
            $soutenance->juryMembres()->delete();

            foreach ($juryIds as $enseignantId) {
                $fonction = 'examinateur';
                if ($enseignantId == $request->president_id) $fonction = 'président';
                elseif ($enseignantId == $request->rapporteur_id) $fonction = 'rapporteur';

                JuryMembre::create([
                    'soutenance_id' => $soutenance->id,
                    'enseignant_id' => $enseignantId,
                    'fonction' => $fonction,
                ]);
            }

            // Notification de modification
            $soutenance->notifyStudent('modification_planification');
        });

        return redirect()->route('planification.index')->with('success', "La planification a été mise à jour.");
    }

    public function destroy($id)
    {
        $soutenance = Soutenance::findOrFail($id);
        $soutenance->notifyStudent('annulation');
        $soutenance->delete();

        return redirect()->route('planification.index')->with('success', "La planification a été supprimée et les participants notifiés.");
    }

    public function annuler($id)
    {
        $soutenance = Soutenance::findOrFail($id);
        $soutenance->update(['statut' => 'annulee']);
        $soutenance->notifyStudent('annulation');

        return back()->with('success', "La soutenance a été annulée et les participants notifiés.");
    }

    public function getStudentTheme($etudiantId)
    {
        $memoire = Memoire::where('etudiant_id', $etudiantId)->latest()->first();
        return response()->json([
            'theme' => $memoire ? $memoire->titre : ''
        ]);
    }
}
