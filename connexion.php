<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="index.html">Retour à l'index</a>

    <h2>Connexion</h2>
    <form action="form/connexion.php" method="POST">
        <label for="pseudo">Pseudo:</label><br>
        <input type="text" id="pseudo" name="pseudo" required><br><br>
        <label for="mdp">Mot de passe:</label><br>
        <input type="password" id="mdp" name="mdp" required><br><br>
        <input type="submit" value="Se connecter">
    </form>


</body>

</html>

<!--
    Comptes : 
    AH - 1234
    admin - nice
    test - test
-->