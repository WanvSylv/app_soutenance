<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Parametre;
use Illuminate\Http\Request;

class ParametreController extends Controller
{
    /**
     * Afficher tous les paramètres dans un formulaire unique.
     */
    public function index()
    {
        $parametres = Parametre::orderBy('cle')->get()->keyBy('cle');
        return view('admin.parametres.index', compact('parametres'));
    }

    /**
     * Mettre à jour tous les paramètres en une seule soumission.
     */
    public function update(Request $request)
    {
        $request->validate([
            'duree_soutenance'      => 'required|integer|min:15|max:240',
            'taille_max_memoire_mo' => 'required|integer|min:1|max:500',
            'note_passage'          => 'required|numeric|min:0|max:20',
            'delai_convocation_j'   => 'required|integer|min:1|max:30',
            'email_contact'         => 'required|email',
            'nom_institution'       => 'required|string|max:200',
            'ville_institution'     => 'required|string|max:100',
        ]);

        $definitions = [
            'duree_soutenance'      => 'Durée standard d\'une soutenance (en minutes)',
            'taille_max_memoire_mo' => 'Taille maximale autorisée pour le dépôt de mémoire (en Mo)',
            'note_passage'          => 'Note minimale pour valider une soutenance (/20)',
            'delai_convocation_j'   => 'Délai minimum d\'envoi des convocations avant la soutenance (en jours)',
            'email_contact'         => 'Adresse email de contact de l\'administration',
            'nom_institution'       => 'Nom officiel de l\'institution',
            'ville_institution'     => 'Ville de l\'institution',
        ];

        foreach ($definitions as $cle => $description) {
            Parametre::updateOrCreate(
                ['cle' => $cle],
                ['valeur' => $request->input($cle), 'description' => $description]
            );
        }

        return redirect()->route('admin.parametres.index')->with('success', 'Paramètres mis à jour avec succès.');
    }
}
