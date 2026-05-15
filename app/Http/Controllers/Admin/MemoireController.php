<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\MemoireStatutMail;
use App\Models\Memoire;
use App\Models\MemoireVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MemoireController extends Controller
{
    public function index(Request $request)
    {
        $query = Memoire::with(['etudiant.user', 'anneeAcademique']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('etudiant.user', function ($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                  ->orWhere('prenom', 'like', "%$search%");
            });
        }

        if ($request->filled('statut') && $request->statut !== 'all') {
            $query->where('statut', $request->statut);
        }

        $memoires = $query->latest()->paginate(15);

        return view('admin.memoires.index', compact('memoires'));
    }

    public function valider(Request $request, Memoire $memoire)
    {
        $this->sauvegarderVersion($memoire, 'valide', null);

        $memoire->update([
            'statut'    => 'valide',
            'valide_at' => now(),
            'valide_par' => auth()->id(),
            'motif_rejet' => null,
        ]);

        $memoire->etudiant->user->notify(new \App\Notifications\SimpleNotification(
            'Mémoire Validé',
            'Votre mémoire "' . $memoire->titre . '" a été validé par l\'administration.',
            route('etudiant.memoire.index')
        ));

        try {
            Mail::to($memoire->etudiant->user->email)
                ->send(new MemoireStatutMail($memoire, 'valide'));
        } catch (\Exception $e) {
            // email non bloquant
        }

        return back()->with('success', "Le mémoire de {$memoire->etudiant->user->nom} a été validé.");
    }

    public function rejeter(Request $request, Memoire $memoire)
    {
        $request->validate([
            'motif_rejet' => 'required|string|max:1000',
        ]);

        $this->sauvegarderVersion($memoire, 'rejete', $request->motif_rejet);

        $memoire->update([
            'statut'     => 'rejete',
            'motif_rejet' => $request->motif_rejet,
            'valide_at'  => now(),
            'valide_par' => auth()->id(),
        ]);

        $memoire->etudiant->user->notify(new \App\Notifications\SimpleNotification(
            'Mémoire Rejeté',
            'Votre mémoire "' . $memoire->titre . '" a été rejeté. Motif : ' . $request->motif_rejet,
            route('etudiant.memoire.index')
        ));

        try {
            Mail::to($memoire->etudiant->user->email)
                ->send(new MemoireStatutMail($memoire, 'rejete', $request->motif_rejet));
        } catch (\Exception $e) {
            // email non bloquant
        }

        return back()->with('success', "Le mémoire de {$memoire->etudiant->user->nom} a été rejeté.");
    }

    public function demanderCorrection(Request $request, Memoire $memoire)
    {
        $request->validate([
            'motif_correction' => 'required|string|max:2000',
        ]);

        $this->sauvegarderVersion($memoire, 'corrections_demandees', $request->motif_correction);

        $memoire->update([
            'statut'      => 'corrections_demandees',
            'motif_rejet' => $request->motif_correction,
            'valide_at'   => now(),
            'valide_par'  => auth()->id(),
        ]);

        $memoire->etudiant->user->notify(new \App\Notifications\SimpleNotification(
            'Corrections demandées',
            'Des corrections sont demandées pour votre mémoire "' . $memoire->titre . '". Connectez-vous pour soumettre une nouvelle version.',
            route('etudiant.memoire.index')
        ));

        try {
            Mail::to($memoire->etudiant->user->email)
                ->send(new MemoireStatutMail($memoire, 'corrections_demandees', $request->motif_correction));
        } catch (\Exception $e) {
            // email non bloquant
        }

        return back()->with('success', "Demande de correction envoyée à {$memoire->etudiant->user->nom}.");
    }

    public function download(Memoire $memoire)
    {
        if (!Storage::exists($memoire->fichier_path)) {
            return back()->with('error', 'Le fichier est introuvable.');
        }

        return Storage::download($memoire->fichier_path, 'Memoire_' . $memoire->etudiant->matricule . '.pdf');
    }

    public function downloadVersion(MemoireVersion $version)
    {
        if (!Storage::exists($version->fichier_path)) {
            return back()->with('error', 'Le fichier est introuvable.');
        }

        return Storage::download(
            $version->fichier_path,
            'Memoire_' . $version->memoire->etudiant->matricule . '_V' . $version->numero_version . '.pdf'
        );
    }

    private function sauvegarderVersion(Memoire $memoire, string $statutApres, ?string $motif): void
    {
        MemoireVersion::create([
            'memoire_id'      => $memoire->id,
            'numero_version'  => $memoire->numero_version,
            'titre'           => $memoire->titre,
            'resume'          => $memoire->resume,
            'fichier_path'    => $memoire->fichier_path,
            'taille_fichier_ko' => $memoire->taille_fichier_ko,
            'date_depot'      => $memoire->date_depot,
            'statut_apres'    => $statutApres,
            'motif'           => $motif,
            'traite_par'      => auth()->id(),
            'traite_at'       => now(),
        ]);
    }
}
