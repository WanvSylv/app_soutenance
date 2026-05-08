<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soutenance;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PVController extends Controller
{
    public function generate(Soutenance $soutenance)
    {
        $soutenance->load(['etudiant.user', 'juryMembres.enseignant.user', 'salle', 'procesVerbal.validator']);

        if ($soutenance->statut != 'terminee' || !$soutenance->procesVerbal) {
            return back()->with('error', "Le PV ne peut être généré que pour une soutenance délibérée.");
        }

        // On s'assure que le dossier existe
        if (!file_exists(storage_path('app/public/pvs'))) {
            mkdir(storage_path('app/public/pvs'), 0755, true);
        }

        $pdf = Pdf::loadView('admin.pdf.pv', compact('soutenance'));
        
        $fileName = 'PV_Soutenance_' . $soutenance->etudiant->matricule . '.pdf';
        
        // Sauvegarder le fichier (optionnel mais utile si on veut l'envoyer)
        $pdf->save(storage_path('app/public/pvs/' . $fileName));
        
        $soutenance->procesVerbal->update([
            'fichier_pdf_path' => 'pvs/' . $fileName,
            'genere_at' => now()
        ]);
        
        return $pdf->stream($fileName);
    }

    public function publish(Soutenance $soutenance)
    {
        if ($soutenance->statut != 'terminee' || !$soutenance->procesVerbal) {
            return back()->with('error', "Impossible de publier les résultats d'une soutenance non délibérée.");
        }

        if ($soutenance->procesVerbal->resultats_publies) {
            return back()->with('error', "Ces résultats ont déjà été publiés.");
        }

        $soutenance->procesVerbal->update([
            'resultats_publies' => true,
            'resultats_publies_at' => now()
        ]);

        // Notification email à l'étudiant
        $soutenance->notifyStudent('resultat');

        return back()->with('success', "Les résultats ont été publiés et l'étudiant a été notifié par email.");
    }
}
