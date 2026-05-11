<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soutenance;
use App\Models\Salle;
use App\Models\AnneeAcademique;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PlanificationPDFController extends Controller
{
    public function exportHebdo(Request $request)
    {
        $dateRef = $request->filled('date') ? Carbon::parse($request->date) : now();
        $startOfWeek = $dateRef->copy()->startOfWeek();
        $endOfWeek = $dateRef->copy()->endOfWeek();

        $anneeActive = AnneeAcademique::where('active', true)->first();

        $soutenances = Soutenance::with(['etudiant.user', 'salle', 'juryMembres.enseignant.user'])
            ->whereBetween('date_heure_debut', [$startOfWeek, $endOfWeek])
            ->orderBy('date_heure_debut', 'asc')
            ->get();

        $data = [
            'soutenances' => $soutenances,
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
            'anneeActive' => $anneeActive,
            'generationDate' => now(),
        ];

        $pdf = Pdf::loadView('admin.pdf.planning_hebdo', $data);
        
        // Configuration paysage pour un planning
        $pdf->setPaper('a4', 'landscape');

        $fileName = 'Planning_Soutenances_Semaine_' . $startOfWeek->format('d_m_Y') . '.pdf';
        
        return $pdf->stream($fileName);
    }
}
