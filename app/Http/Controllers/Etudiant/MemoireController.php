<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Memoire;
use App\Models\AnneeAcademique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemoireController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $etudiant = $user->etudiant;

        if (!$etudiant) {
            return redirect()->route('dashboard')->with('error', "Votre profil étudiant est incomplet. Veuillez contacter l'administration.");
        }

        $anneeActive = AnneeAcademique::where('active', true)->first();
        $eligible = $etudiant->quitus_valide;
        $paramSize = \App\Models\Parametre::where('cle', 'taille_max_memoire_mo')->first();
        $maxMo = $paramSize ? (int)$paramSize->valeur : 50;

        $memoire = $anneeActive
            ? $etudiant->memoires()->where('annee_academique_id', $anneeActive->id)->latest()->first()
            : null;

        $versions = $memoire ? $memoire->versions()->latest('numero_version')->get() : collect();

        return view('etudiant.memoire.index', compact('etudiant', 'memoire', 'anneeActive', 'eligible', 'maxMo', 'versions'));
    }

    public function store(Request $request)
    {
        $parametre = \App\Models\Parametre::where('cle', 'taille_max_memoire_mo')->first();
        $maxMo = $parametre ? (int)$parametre->valeur : 50;
        $maxKo = $maxMo * 1024;

        $request->validate([
            'titre'   => 'required|string|max:500',
            'resume'  => 'nullable|string',
            'fichier' => 'required|mimes:pdf|max:' . $maxKo,
        ]);

        $anneeActive = AnneeAcademique::where('active', true)->first();
        if (!$anneeActive) {
            return back()->with('error', "Aucune année académique n'est active actuellement.");
        }

        $etudiant = auth()->user()->etudiant;

        if (!$etudiant) {
            return back()->with('error', "Votre profil étudiant est incomplet.");
        }

        if (!$etudiant->quitus_valide) {
            return back()->with('error', "Vous ne pouvez pas déposer de mémoire sans avoir obtenu votre quitus.");
        }

        $memoireExistant = $etudiant->memoires()
            ->where('annee_academique_id', $anneeActive->id)
            ->latest()
            ->first();

        if ($memoireExistant) {
            // Re-soumission autorisée uniquement si corrections demandées ou rejeté
            if (!$memoireExistant->isResoumettable()) {
                return back()->with('error', "Vous avez déjà déposé un mémoire pour l'année en cours.");
            }

            // Incrémenter la version et remplacer le fichier
            $path = $request->file('fichier')->store('memoires');

            $memoireExistant->update([
                'titre'           => $request->titre,
                'resume'          => $request->resume,
                'fichier_path'    => $path,
                'taille_fichier_ko' => round($request->file('fichier')->getSize() / 1024),
                'date_depot'      => now(),
                'statut'          => 'en_attente',
                'motif_rejet'     => null,
                'valide_at'       => null,
                'valide_par'      => null,
                'numero_version'  => $memoireExistant->numero_version + 1,
            ]);

            auth()->user()->notify(new \App\Notifications\SimpleNotification(
                'Nouvelle version déposée',
                'Votre mémoire version V' . $memoireExistant->numero_version . ' a été soumis avec succès.',
                route('etudiant.memoire.index')
            ));

            return redirect()->route('etudiant.memoire.index')
                ->with('success', 'Votre nouvelle version a été soumise avec succès.');
        }

        $path = $request->file('fichier')->store('memoires');

        Memoire::create([
            'etudiant_id'        => $etudiant->id,
            'annee_academique_id' => $anneeActive->id,
            'titre'              => $request->titre,
            'resume'             => $request->resume,
            'fichier_path'       => $path,
            'taille_fichier_ko'  => round($request->file('fichier')->getSize() / 1024),
            'date_depot'         => now(),
            'numero_version'     => 1,
        ]);

        auth()->user()->notify(new \App\Notifications\SimpleNotification(
            'Dépôt de mémoire',
            'Votre mémoire "' . $request->titre . '" a été déposé avec succès.',
            route('etudiant.memoire.index')
        ));

        return redirect()->route('etudiant.memoire.index')
            ->with('success', 'Votre mémoire a été déposé avec succès.');
    }

    public function viewFile()
    {
        $etudiant = auth()->user()->etudiant;

        if (!$etudiant) {
            return back()->with('error', "Votre profil étudiant est incomplet.");
        }

        $memoire = $etudiant->memoires()->latest()->first();

        if (!$memoire || !Storage::exists($memoire->fichier_path)) {
            return back()->with('error', 'Le fichier mémoire est introuvable.');
        }

        return response()->file(Storage::path($memoire->fichier_path));
    }

    public function download()
    {
        $etudiant = auth()->user()->etudiant;

        if (!$etudiant) {
            return back()->with('error', "Votre profil étudiant est incomplet.");
        }

        $memoire = $etudiant->memoires()->latest()->first();

        if (!$memoire || !Storage::exists($memoire->fichier_path)) {
            return back()->with('error', 'Le fichier mémoire est introuvable.');
        }

        return Storage::download($memoire->fichier_path, 'Memoire_' . $etudiant->matricule . '.pdf');
    }
}
