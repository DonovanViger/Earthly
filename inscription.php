<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Connexion</title>
</head>
<body>

<a href="index.php">Retour à l'index</a>

<h2>Créer un compte</h2>
<form action="form/form_inscription.php" method="POST">
    <label for="pseudo">Pseudo:</label><br>
    <input type="text" id="pseudo" name="pseudo" required><br><br>
    <label for="email">Adresse e-mail:</label><br>
    <input type="email" id="email" name="email" required><br><br>
    <label for="mdp">Mot de passe:</label><br>
    <input type="password" id="mdp" name="mdp" required><br><br>
    <input type="submit" value="Créer un compte">
</form>

<!--
    Comptes : 
    AH - 1234
    admin - nice
    test - test
-->

</body>
</html>