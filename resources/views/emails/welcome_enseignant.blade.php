<!DOCTYPE html>
<html>
<body>
    <h2>Bienvenue sur HOREB IP</h2>
    <p>Bonjour {{ $user->prenom }} {{ $user->nom }},</p>
    <p>Votre compte Jury a été créé. Voici vos identifiants temporaires :</p>
    <ul>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Mot de passe:</strong> {{ $password }}</li>
    </ul>
    <p>Veuillez modifier votre mot de passe dès votre première connexion.</p>
</body>
</html>
