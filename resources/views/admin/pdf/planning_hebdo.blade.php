<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Planning des Soutenances</title>
    <style>
        @page {
            margin: 1cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1b254b;
            line-height: 1.4;
            font-size: 10pt;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2d60ff;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #2d60ff;
            text-transform: uppercase;
            font-size: 18pt;
        }
        .header p {
            margin: 5px 0;
            color: #a3aed0;
            font-weight: bold;
        }
        .info-bar {
            margin-bottom: 20px;
            background-color: #f4f7fe;
            padding: 10px;
            border-radius: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #2d60ff;
            color: white;
            text-transform: uppercase;
            font-size: 8pt;
            padding: 10px;
            text-align: left;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #e0e5f2;
            vertical-align: top;
        }
        .date-cell {
            font-weight: bold;
            color: #2d60ff;
            width: 80px;
        }
        .time-cell {
            font-weight: bold;
            width: 60px;
        }
        .student-cell {
            font-weight: bold;
            width: 150px;
        }
        .subject-cell {
            font-style: italic;
            color: #4a5568;
        }
        .jury-cell {
            font-size: 9pt;
        }
        .jury-member {
            display: block;
            margin-bottom: 2px;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-president { background-color: #ebf4ff; color: #2d60ff; border: 1px solid #d1e3ff; }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8pt;
            color: #a3aed0;
            border-top: 1px solid #e0e5f2;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>HOREB ACADEMY - PLANNING DES SOUTENANCES</h1>
        <p>Semaine du {{ $startOfWeek->format('d/m/Y') }} au {{ $endOfWeek->format('d/m/Y') }}</p>
    </div>

    <div class="info-bar">
        <strong>Session :</strong> {{ $anneeActive->libelle ?? 'N/A' }} | 
        <strong>Généré le :</strong> {{ $generationDate->format('d/m/Y à H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Étudiant</th>
                <th>Sujet / Thème</th>
                <th>Salle</th>
                <th>Jury</th>
            </tr>
        </thead>
        <tbody>
            @forelse($soutenances as $soutenance)
                <tr>
                    <td class="date-cell">{{ $soutenance->date_heure_debut->translatedFormat('d M Y') }}</td>
                    <td class="time-cell">{{ $soutenance->date_heure_debut->format('H:i') }}</td>
                    <td class="student-cell">
                        {{ strtoupper($soutenance->etudiant->user->nom) }} {{ $soutenance->etudiant->user->prenom }}<br>
                        <small style="color: #a3aed0; font-weight: normal;">{{ $soutenance->etudiant->matricule }}</small>
                    </td>
                    <td class="subject-cell">{{ $soutenance->sujet }}</td>
                    <td><strong>{{ $soutenance->salle->nom }}</strong></td>
                    <td class="jury-cell">
                        @foreach($soutenance->juryMembres as $membre)
                            <span class="jury-member">
                                <strong>{{ $membre->enseignant->user->nom }}</strong> ({{ $membre->fonction }})
                            </span>
                        @endforeach
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #a3aed0;">
                        Aucune soutenance planifiée pour cette semaine.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        © {{ date('Y') }} HOREB IP - Système de Gestion des Soutenances | Page 1/1
    </div>
</body>
</html>
