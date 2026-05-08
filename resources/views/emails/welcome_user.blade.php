<!DOCTYPE html>
<html>
<body>
    <h2>Bienvenue sur HOREB IP</h2>
    <p>Bonjour {{ $user->prenom }} {{ $user->nom }},</p>
    <p>Votre compte a été créé avec succès sur la plateforme de gestion des soutenances. Voici vos identifiants temporaires :</p>
    <ul>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Mot de passe:</strong> {{ $password }}</li>
    </ul>
    <p>Veuillez vous connecter à l'adresse <a href="{{ url('/') }}">{{ url('/') }}</a> et modifier votre mot de passe dès votre première connexion dans les paramètres de votre compte.</p>
    <br>
    <p>L'équipe technique HOREB IP</p>
</body>
</html>
