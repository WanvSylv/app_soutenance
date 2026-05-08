<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Procès-Verbal de Soutenance - {{ $soutenance->etudiant->matricule }}</title>
    <style>
        body { font-family: "DejaVu Sans", sans-serif; font-size: 12px; color: #333; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1B254B; padding-bottom: 15px; }
        .title { font-size: 18px; font-weight: bold; text-transform: uppercase; margin: 10px 0; color: #1B254B; }
        .subtitle { font-size: 14px; font-weight: bold; margin-bottom: 20px; text-align: center; }
        .section { margin-bottom: 20px; }
        .section-title { font-weight: bold; background-color: #f3f4f6; padding: 5px 10px; border-left: 4px solid #1B254B; margin-bottom: 10px; }
        table { w-full; border-collapse: collapse; margin-bottom: 15px; width: 100%; }
        th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; }
        th { background-color: #f9fafb; font-weight: bold; width: 30%; }
        .signatures { margin-top: 50px; width: 100%; }
        .signatures td { border: none; text-align: center; width: 33%; vertical-align: top; }
        .signature-title { font-weight: bold; margin-bottom: 50px; text-decoration: underline; }
        .footer { position: fixed; bottom: -30px; left: 0; right: 0; text-align: center; font-size: 10px; color: #6b7280; border-top: 1px solid #d1d5db; padding-top: 10px; }
        .decision { font-size: 14px; font-weight: bold; text-align: center; padding: 15px; border: 2px solid #1B254B; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPUBLIQUE DU BENIN</h1>
        <h2>HOREB IP - Institut Polytechnique</h2>
        <div class="title">Procès-Verbal de Soutenance de Mémoire</div>
        <div>Année Académique : {{ $soutenance->anneeAcademique->libelle }}</div>
    </div>

    <div class="section">
        <div class="section-title">Informations de l'Impétrant</div>
        <table>
            <tr><th>Nom & Prénoms</th><td>{{ strtoupper($soutenance->etudiant->user->nom) }} {{ $soutenance->etudiant->user->prenom }}</td></tr>
            <tr><th>Matricule</th><td>{{ $soutenance->etudiant->matricule }}</td></tr>
            <tr><th>Filière</th><td>{{ $soutenance->etudiant->filiere }}</td></tr>
            <tr><th>Thème du mémoire</th><td>{{ $soutenance->sujet }}</td></tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Informations de la Soutenance</div>
        <table>
            <tr><th>Date et Heure</th><td>{{ $soutenance->date_heure_debut->format('d/m/Y à H:i') }}</td></tr>
            <tr><th>Salle</th><td>{{ $soutenance->salle->nom }}</td></tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Composition du Jury</div>
        <table>
            @foreach($soutenance->juryMembres as $membre)
                <tr>
                    <th>{{ ucfirst($membre->fonction) }}</th>
                    <td>{{ $membre->enseignant->user->nom }} {{ $membre->enseignant->user->prenom }} ({{ $membre->enseignant->specialite }})</td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="section">
        <div class="section-title">Délibération et Décision</div>
        <table>
            <tr><th>Note Finale</th><td><strong>{{ number_format($soutenance->procesVerbal->note_finale, 2) }} / 20</strong></td></tr>
            <tr><th>Mention</th><td><strong>{{ $soutenance->procesVerbal->mention }}</strong></td></tr>
            <tr><th>Observations générales</th><td>{{ $soutenance->procesVerbal->observations ?? 'Néant' }}</td></tr>
        </table>

        <div class="decision">
            Décision du jury : 
            @if($soutenance->procesVerbal->decision == 'admis')
                ADMIS(E)
            @elseif($soutenance->procesVerbal->decision == 'félicitations')
                ADMIS(E) AVEC FÉLICITATIONS
            @else
                AJOURNÉ(E)
            @endif
        </div>
    </div>

    <table class="signatures">
        <tr>
            <td>
                <div class="signature-title">Le Président du Jury</div>
                @php $president = $soutenance->juryMembres->where('fonction', 'président')->first(); @endphp
                {{ $president ? $president->enseignant->user->nom . ' ' . $president->enseignant->user->prenom : '' }}
            </td>
            <td>
                <div class="signature-title">L'Examinateur</div>
                @php $examinateur = $soutenance->juryMembres->where('fonction', 'examinateur')->first(); @endphp
                {{ $examinateur ? $examinateur->enseignant->user->nom . ' ' . $examinateur->enseignant->user->prenom : '' }}
            </td>
            <td>
                <div class="signature-title">Le Rapporteur</div>
                @php $rapporteur = $soutenance->juryMembres->where('fonction', 'rapporteur')->first(); @endphp
                {{ $rapporteur ? $rapporteur->enseignant->user->nom . ' ' . $rapporteur->enseignant->user->prenom : '' }}
            </td>
        </tr>
    </table>

    <div class="footer">
        Fait à Cotonou, le {{ $soutenance->procesVerbal->valide_at ? \Carbon\Carbon::parse($soutenance->procesVerbal->valide_at)->format('d/m/Y') : now()->format('d/m/Y') }}<br>
        Document généré électroniquement par HOREB IP.
    </div>
</body>
</html>
