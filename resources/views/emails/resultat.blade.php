<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f7ff; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; padding: 40px; text-align: center; }
        .content { padding: 40px; color: #334155; line-height: 1.6; }
        .result-card { background: #ecfdf5; border-radius: 12px; padding: 30px; text-align: center; margin: 20px 0; border: 1px solid #a7f3d0; }
        .note { font-size: 48px; font-weight: 800; color: #059669; margin: 10px 0; }
        .mention { font-weight: bold; color: #065f46; text-transform: uppercase; letter-spacing: 1px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; }
        .btn { display: inline-block; padding: 12px 24px; background: #10b981; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; font-size: 24px;">FÉLICITATIONS !</h1>
            <p style="margin:10px 0 0; opacity: 0.8;">Résultats de Soutenance</p>
        </div>
        <div class="content">
            <h2 style="color: #1e293b;">Bravo {{ $soutenance->etudiant->user->prenom }},</h2>
            <p>Le jury a délibéré suite à votre présentation. Nous avons le plaisir de vous annoncer que vous avez validé votre soutenance de mémoire.</p>
            
            <div class="result-card">
                <div style="font-size: 14px; color: #065f46; font-weight: bold;">NOTE FINALE</div>
                <div class="note">{{ number_format($soutenance->procesVerbal->note_finale, 2) }}/20</div>
                <div class="mention">Mention : {{ $soutenance->procesVerbal->mention }}</div>
                <div style="margin-top: 10px; font-weight: bold;">
                    Décision : 
                    @if($soutenance->procesVerbal->decision == 'admis')
                        ADMIS(E)
                    @elseif($soutenance->procesVerbal->decision == 'félicitations')
                        ADMIS(E) AVEC FÉLICITATIONS
                    @else
                        <span style="color: #ef4444;">AJOURNÉ(E)</span>
                    @endif
                </div>
            </div>

            <p>Vous pouvez dès à présent vous connecter à votre portail pour consulter le détail de vos notes et les observations du jury.</p>
            
            <a href="{{ url('/') }}" class="btn">Consulter mon espace</a>
        </div>
        <div class="footer">
            &copy; 2026 HOREB IP - Institut Polytechnique. <br>
            Cotonou, Bénin.
        </div>
    </div>
</body>
</html>
