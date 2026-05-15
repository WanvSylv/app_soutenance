<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f7ff; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { color: #ffffff; padding: 40px; text-align: center; }
        .header-valide      { background: linear-gradient(135deg, #059669 0%, #047857 100%); }
        .header-rejete      { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); }
        .header-corrections { background: linear-gradient(135deg, #d97706 0%, #b45309 100%); }
        .content { padding: 40px; color: #334155; line-height: 1.6; }
        .details { background: #f8fafc; border-radius: 12px; padding: 20px; margin: 20px 0; border: 1px solid #e2e8f0; }
        .details-item { margin-bottom: 10px; font-size: 14px; }
        .details-label { font-weight: bold; color: #64748b; width: 130px; display: inline-block; vertical-align: top; }
        .motif-box { border-radius: 10px; padding: 16px 20px; margin: 20px 0; font-size: 14px; line-height: 1.7; }
        .motif-rejete      { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .motif-corrections { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; }
        .btn { display: inline-block; padding: 12px 24px; background: #2563eb; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header
            @if($typeStatut === 'valide') header-valide
            @elseif($typeStatut === 'rejete') header-rejete
            @else header-corrections
            @endif">
            <h1 style="margin:0; font-size: 24px;">HOREB IP</h1>
            <p style="margin:10px 0 0; opacity: 0.85;">
                @if($typeStatut === 'valide') Mémoire Validé ✓
                @elseif($typeStatut === 'rejete') Mémoire Rejeté
                @else Corrections Demandées
                @endif
            </p>
        </div>

        <div class="content">
            <h2 style="color: #1e293b;">Bonjour {{ $memoire->etudiant->user->prenom }},</h2>

            @if($typeStatut === 'valide')
                <p>Nous avons le plaisir de vous informer que votre mémoire a été <strong>validé</strong> par l'administration. Vous serez prochainement convoqué pour votre soutenance.</p>
            @elseif($typeStatut === 'rejete')
                <p>Nous vous informons que votre mémoire a été <strong>rejeté</strong> par l'administration pour les raisons indiquées ci-dessous.</p>
            @else
                <p>L'administration a examiné votre mémoire et vous demande d'apporter des <strong>corrections</strong> avant de le re-soumettre. Veuillez prendre en compte les remarques ci-dessous.</p>
            @endif

            <div class="details">
                <div class="details-item">
                    <span class="details-label">Étudiant :</span>
                    {{ $memoire->etudiant->user->nom }} {{ $memoire->etudiant->user->prenom }}
                </div>
                <div class="details-item">
                    <span class="details-label">Matricule :</span>
                    {{ $memoire->etudiant->matricule }}
                </div>
                <div class="details-item">
                    <span class="details-label">Titre :</span>
                    {{ $memoire->titre }}
                </div>
                <div class="details-item">
                    <span class="details-label">Année académique :</span>
                    {{ $memoire->anneeAcademique?->libelle ?? '—' }}
                </div>
                <div class="details-item">
                    <span class="details-label">Version :</span>
                    V{{ $memoire->numero_version }}
                </div>
            </div>

            @if($motif && in_array($typeStatut, ['rejete', 'corrections_demandees']))
                <div class="motif-box {{ $typeStatut === 'rejete' ? 'motif-rejete' : 'motif-corrections' }}">
                    <strong>
                        @if($typeStatut === 'rejete') Motif du rejet :
                        @else Corrections à apporter :
                        @endif
                    </strong><br>
                    {!! nl2br(e($motif)) !!}
                </div>
            @endif

            @if($typeStatut === 'corrections_demandees')
                <p>Vous pouvez vous connecter à votre espace étudiant pour soumettre une nouvelle version de votre mémoire.</p>
            @endif

            <a href="{{ url('/etudiant/memoire') }}" class="btn">Accéder à mon espace</a>
        </div>

        <div class="footer">
            <p>Ce message est envoyé automatiquement par le système HOREB IP.<br>Merci de ne pas répondre à cet email.</p>
        </div>
    </div>
</body>
</html>
