<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Connexion</title>
</head>
<body>

<h2>Connexion</h2>
<form action="connexion.php" method="POST">
    <label for="pseudo">Pseudo:</label><br>
    <input type="text" id="pseudo" name="pseudo" required><br><br>
    <label for="mdp">Mot de passe:</label><br>
    <input type="password" id="mdp" name="mdp" required><br><br>
    <input type="submit" value="Se connecter">
</form>

</body>
</html>
