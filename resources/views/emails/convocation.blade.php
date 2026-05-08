<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f7ff; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: #ffffff; padding: 40px; text-align: center; }
        .content { padding: 40px; color: #334155; line-height: 1.6; }
        .details { background: #f8fafc; border-radius: 12px; padding: 20px; margin: 20px 0; border: 1px solid #e2e8f0; }
        .details-item { margin-bottom: 10px; font-size: 14px; }
        .details-label { font-weight: bold; color: #64748b; width: 100px; display: inline-block; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; }
        .btn { display: inline-block; padding: 12px 24px; background: #2563eb; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; font-size: 24px;">HOREB IP</h1>
            <p style="margin:10px 0 0; opacity: 0.8;">Convocation Officielle</p>
        </div>
        <div class="content">
            <h2 style="color: #1e293b;">Bonjour {{ $soutenance->etudiant->user->prenom }},</h2>
            <p>Nous avons le plaisir de vous informer que la date de votre soutenance de mémoire a été fixée. Veuillez trouver ci-dessous les détails de votre convocation :</p>
            
            <div class="details">
                <div class="details-item"><span class="details-label">Date :</span> {{ $soutenance->date_heure_debut->format('d/m/Y') }}</div>
                <div class="details-item"><span class="details-label">Heure :</span> {{ $soutenance->date_heure_debut->format('H:i') }}</div>
                <div class="details-item"><span class="details-label">Salle :</span> {{ $soutenance->salle->nom }}</div>
                <div class="details-item"><span class="details-label">Jury :</span> 
                    @foreach($soutenance->juryMembres as $membre)
                        {{ $membre->enseignant->user->nom }} ({{ ucfirst($membre->fonction) }}){{ !$loop->last ? ', ' : '' }}
                    @endforeach
                </div>
            </div>

            <p>Nous vous recommandons d'arriver au moins 30 minutes avant l'heure prévue pour installer votre présentation.</p>
            
            <a href="{{ url('/') }}" class="btn">Accéder au Portail</a>
        </div>
        <div class="footer">
            &copy; 2026 HOREB IP - Institut Polytechnique. <br>
            Cotonou, Bénin.
        </div>
    </div>
</body>
</html>
