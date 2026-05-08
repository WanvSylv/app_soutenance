<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Soutenance;
use App\Models\CritereEvaluation;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    public function index()
    {
        $enseignant = auth()->user()->enseignant;
        
        if (!$enseignant) {
            return redirect()->route('dashboard')->with('error', "Profil enseignant non trouvé.");
        }

        $soutenances = Soutenance::whereHas('juryMembres', function($q) use ($enseignant) {
            $q->where('enseignant_id', $enseignant->id);
        })
        ->with(['etudiant.user', 'salle', 'anneeAcademique'])
        ->latest()
        ->get();

        return view('enseignant.evaluations.index', compact('soutenances'));
    }

    public function evaluate(Soutenance $soutenance)
    {
        $enseignant = auth()->user()->enseignant;

        if (!$soutenance->juryMembres()->where('enseignant_id', $enseignant->id)->exists()) {
            abort(403, 'Vous ne faites pas partie du jury de cette soutenance.');
        }

        // Vérification de l'heure de la soutenance
        if (now()->lt($soutenance->date_heure_debut)) {
            return redirect()->route('enseignant.evaluations.index')->with('error', "Vous ne pouvez pas encore évaluer cette soutenance. Elle est prévue pour le " . $soutenance->date_heure_debut->format('d/m/Y à H:i') . ".");
        }

        // Vérification du statut (si annulée ou autre)
        if ($soutenance->statut === 'annulee') {
            return redirect()->route('enseignant.evaluations.index')->with('error', "Cette soutenance a été annulée et ne peut plus être évaluée.");
        }

        $criteres = CritereEvaluation::where('actif', true)->orderBy('ordre')->get();
        
        $notesExistantes = Note::where('soutenance_id', $soutenance->id)
            ->where('enseignant_id', $enseignant->id)
            ->get()->keyBy('critere_id');

        $membre = $soutenance->juryMembres()->where('enseignant_id', $enseignant->id)->first();
        $isPresident = $membre->fonction === 'président';
        
        $notationComplete = $soutenance->isNotationComplete();
        $hasValidated = $notesExistantes->where('valide', true)->isNotEmpty();

        return view('enseignant.evaluations.evaluate', compact('soutenance', 'criteres', 'notesExistantes', 'isPresident', 'notationComplete', 'hasValidated'));
    }

    public function store(Request $request, Soutenance $soutenance)
    {
        $this->saveNotes($request, $soutenance, false);
        return redirect()->back()->with('success', 'Brouillon enregistré. N\'oubliez pas de valider vos notes définitivement.');
    }

    public function validateNotes(Request $request, Soutenance $soutenance)
    {
        $this->saveNotes($request, $soutenance, true);
        
        // Si cette validation complète la notation globale
        if ($soutenance->isNotationComplete()) {
            $president = $soutenance->getJuryPresident();
            if ($president && $president->user) {
                $notifTitle = "Validation de PV requise";
                $notifMessage = "Les notes pour la soutenance de {$soutenance->etudiant->user->nom} sont complètes. Veuillez délibérer et valider le PV.";
                $president->user->notify(new \App\Notifications\SimpleNotification($notifTitle, $notifMessage, route('enseignant.evaluations.index')));

                try {
                    \Illuminate\Support\Facades\Mail::to($president->user->email)->send(new \App\Mail\DemandeValidationPVMail($soutenance));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Erreur d'envoi mail au président pour PV : " . $e->getMessage());
                }
            }
        }
        
        return redirect()->back()->with('success', 'Vos notes ont été validées définitivement.');
    }

    private function saveNotes(Request $request, Soutenance $soutenance, bool $validate)
    {
        $enseignant = auth()->user()->enseignant;

        if (!$soutenance->juryMembres()->where('enseignant_id', $enseignant->id)->exists()) {
            abort(403, 'Action non autorisée.');
        }

        // Sécurité supplémentaire : Empêcher l'enregistrement avant l'heure
        if (now()->lt($soutenance->date_heure_debut)) {
            abort(403, "L'évaluation n'est pas encore ouverte pour cette soutenance.");
        }

        if ($soutenance->statut === 'annulee') {
            abort(403, "Cette soutenance est annulée.");
        }

        // Vérifier si déjà validé
        $alreadyValidated = Note::where('soutenance_id', $soutenance->id)
            ->where('enseignant_id', $enseignant->id)
            ->where('valide', true)
            ->exists();

        if ($alreadyValidated) {
            abort(403, 'Vos notes ont déjà été validées et ne sont plus modifiables.');
        }

        $criteres = CritereEvaluation::where('actif', true)->get();
        $rules = [];
        foreach ($criteres as $critere) {
            // Seule la validation stricte est requise si on valide définitivement
            $rule = 'nullable|numeric|min:0|max:20';
            if ($validate) {
                $rule = 'required|numeric|min:0|max:20';
            }
            $rules['note_' . $critere->id] = $rule;
        }

        $request->validate($rules);

        DB::transaction(function() use ($request, $soutenance, $enseignant, $criteres, $validate) {
            foreach ($criteres as $critere) {
                $valeur = $request->input('note_' . $critere->id);
                if ($valeur !== null) {
                    Note::updateOrCreate(
                        [
                            'soutenance_id' => $soutenance->id, 
                            'enseignant_id' => $enseignant->id,
                            'critere_id' => $critere->id
                        ],
                        [
                            'valeur' => $valeur, 
                            'commentaire' => $request->input('obs_' . $critere->id),
                            'valide' => $validate,
                            'valide_at' => $validate ? now() : null
                        ]
                    );
                }
            }
        });
    }

    public function deliberate(Request $request, Soutenance $soutenance)
    {
        $enseignant = auth()->user()->enseignant;
        $membre = $soutenance->juryMembres()->where('enseignant_id', $enseignant->id)->first();
        
        if (!$membre || $membre->fonction !== 'président') {
            abort(403, 'Seul le président du jury peut procéder à la délibération.');
        }

        if (!$soutenance->isNotationComplete()) {
            return redirect()->back()->with('error', 'Tous les membres du jury n\'ont pas encore validé leurs notes.');
        }

        $request->validate([
            'observations_generales' => 'nullable|string',
        ]);

        DB::transaction(function() use ($request, $soutenance, $enseignant) {
            $noteFinale = $soutenance->calculateNoteFinale();
            $mention = Soutenance::getMention($noteFinale);
            $decision = $noteFinale >= 10 ? 'admis' : 'ajourne';

            if ($noteFinale >= 16) {
                $decision = 'félicitations'; // Adapté selon les statuts possibles
            }

            // Mettre à jour la soutenance
            $soutenance->update([
                'note_finale' => $noteFinale,
                'statut' => 'terminee',
                'observations_generales' => $request->observations_generales,
            ]);

            // Créer le PV
            \App\Models\ProcesVerbal::updateOrCreate(
                ['soutenance_id' => $soutenance->id],
                [
                    'note_finale' => $noteFinale,
                    'mention' => $mention,
                    'decision' => $decision,
                    'observations' => $request->observations_generales,
                    'valide_par' => auth()->id(),
                    'valide_at' => now(),
                ]
            );
        });

        return redirect()->route('enseignant.evaluations.index')->with('success', 'Délibération terminée et PV enregistré avec succès.');
    }

    public function downloadMemoire(Soutenance $soutenance)
    {
        $enseignant = auth()->user()->enseignant;

        if (!$soutenance->juryMembres()->where('enseignant_id', $enseignant->id)->exists()) {
            abort(403, 'Vous n\'êtes pas autorisé à consulter ce mémoire.');
        }

        $memoire = $soutenance->etudiant->memoires()->where('annee_academique_id', $soutenance->annee_academique_id)->first();

        if (!$memoire || !\Illuminate\Support\Facades\Storage::exists($memoire->fichier_path)) {
            return back()->with('error', 'Le mémoire n\'a pas encore été déposé ou est introuvable.');
        }

        return \Illuminate\Support\Facades\Storage::download($memoire->fichier_path, 'Memoire_' . $soutenance->etudiant->matricule . '.pdf');
    }

    public function updateAvailability(Request $request, Soutenance $soutenance)
    {
        $enseignant = auth()->user()->enseignant;
        $membre = $soutenance->juryMembres()->where('enseignant_id', $enseignant->id)->first();

        if (!$membre) {
            abort(403, 'Action non autorisée.');
        }

        $request->validate([
            'statut_confirmation' => 'required|in:confirme,indisponible',
            'motif_indisponibilite' => 'required_if:statut_confirmation,indisponible|nullable|string',
        ]);

        $membre->update([
            'statut_confirmation' => $request->statut_confirmation,
            'motif_indisponibilite' => $request->statut_confirmation === 'indisponible' ? $request->motif_indisponibilite : null,
        ]);

        // Notification aux administrateurs
        $admins = \App\Models\User::where('role', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\JuryResponseNotification($soutenance, $enseignant, $request->statut_confirmation));

        $statusLabel = $request->statut_confirmation === 'confirme' ? 'confirmé' : 'indisponible';
        return redirect()->back()->with('success', "Votre disponibilité a été enregistrée comme : $statusLabel.");
    }
}
