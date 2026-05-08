<!DOCTYPE html>
<html>
<body>
    <h2>Rappel : Soutenance dans 24h</h2>
    <p>Bonjour {{ $user->prenom }} {{ $user->nom }},</p>
    <p>Ceci est un rappel automatique pour la soutenance de {{ $soutenance->etudiant->user->prenom }} {{ $soutenance->etudiant->user->nom }} prévue demain à {{ $soutenance->date_heure_debut->format('H:i') }}.</p>
    <p>Lieu : {{ $soutenance->salle->nom }}</p>
</body>
</html>
