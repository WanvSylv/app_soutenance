<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f7ff; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%); color: #ffffff; padding: 40px; text-align: center; }
        .content { padding: 40px; color: #334155; line-height: 1.6; }
        .details { background: #fff1f2; border-radius: 12px; padding: 25px; margin: 20px 0; border-left: 4px solid #f43f5e; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; font-size: 24px;">ANNULATION DE SOUTENANCE</h1>
        </div>
        <div class="content">
            <h2 style="color: #1e293b;">Bonjour {{ $soutenance->etudiant->user->prenom }},</h2>
            <p>Nous vous informons que votre soutenance de mémoire initialement prévue est **annulée**. </p>
            
            <div class="details">
                <p><strong>Thème :</strong> {{ $soutenance->sujet }}</p>
                <p><strong>Date prévue :</strong> {{ $soutenance->date_heure_debut->format('d/m/Y à H:i') }}</p>
            </div>

            <p>Veuillez contacter l'administration pour plus d'informations ou pour une nouvelle planification.</p>
        </div>
        <div class="footer">
            &copy; 2026 HOREB IP - Institut Polytechnique.
        </div>
    </div>
</body>
</html>
