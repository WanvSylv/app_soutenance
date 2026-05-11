<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Memoire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemoireController extends Controller
{
    public function index(Request $request)
    {
        $query = Memoire::with(['etudiant.user', 'anneeAcademique']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('etudiant.user', function ($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                  ->orWhere('prenom', 'like', "%$search%");
            });
        }

        if ($request->has('statut') && $request->statut != 'all') {
            $query->where('statut', $request->statut);
        }

        $memoires = $query->latest()->paginate(15);

        return view('admin.memoires.index', compact('memoires'));
    }

    public function valider(Request $request, Memoire $memoire)
    {
        $memoire->update([
            'statut' => 'valide',
            'valide_at' => now(),
            'valide_par' => auth()->id(),
        ]);

        // Notifier l'étudiant
        $memoire->etudiant->user->notify(new \App\Notifications\SimpleNotification(
            'Mémoire Validé',
            'Votre mémoire "' . $memoire->titre . '" a été validé par l\'administration.',
            route('etudiant.memoire.index')
        ));

        return back()->with('success', "Le mémoire de {$memoire->etudiant->user->nom} a été validé.");
    }

    public function rejeter(Request $request, Memoire $memoire)
    {
        $request->validate([
            'motif_rejet' => 'required|string|max:1000',
        ]);

        $memoire->update([
            'statut' => 'rejete',
            'motif_rejet' => $request->motif_rejet,
            'valide_at' => now(),
            'valide_par' => auth()->id(),
        ]);

        // Notifier l'étudiant
        $memoire->etudiant->user->notify(new \App\Notifications\SimpleNotification(
            'Mémoire Rejeté',
            'Votre mémoire "' . $memoire->titre . '" a été rejeté pour le motif suivant : ' . $request->motif_rejet,
            route('etudiant.memoire.index')
        ));

        return back()->with('success', "Le mémoire de {$memoire->etudiant->user->nom} a été rejeté.");
    }

    public function download(Memoire $memoire)
    {
        if (!Storage::exists($memoire->fichier_path)) {
            return back()->with('error', 'Le fichier est introuvable.');
        }

        return Storage::download($memoire->fichier_path, 'Memoire_' . $memoire->etudiant->matricule . '.pdf');
    }
}
