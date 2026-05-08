<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class QuitusController extends Controller
{
    public function index(Request $request)
    {
        $query = Etudiant::with('user', 'memoires');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                  ->orWhere('prenom', 'like', "%$search%");
            })->orWhere('matricule', 'like', "%$search%");
        }

        if ($request->has('statut')) {
            if ($request->statut == 'valide') {
                $query->where('quitus_valide', true);
            } elseif ($request->statut == 'en_attente') {
                $query->where('quitus_valide', false);
            }
        }

        $etudiants = $query->latest()->paginate(15);

        return view('admin.quitus.index', compact('etudiants'));
    }

    public function valider(Request $request, Etudiant $etudiant)
    {
        $etudiant->update([
            'quitus_valide' => true,
            'quitus_valide_at' => now(),
            'quitus_valide_par' => auth()->id(),
        ]);

        // Notifier l'étudiant
        $etudiant->user->notify(new \App\Notifications\SimpleNotification(
            'Quitus Validé',
            'Votre quitus a été validé par l\'administration. Vous pouvez désormais déposer votre mémoire.',
            route('etudiant.memoire.index')
        ));

        return back()->with('success', "Le quitus de l'étudiant {$etudiant->user->nom} a été validé.");
    }
}
