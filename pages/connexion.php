<?php
session_start(); // Démarre la session (à placer au début de chaque fichier PHP où vous utilisez des sessions)
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>

<body>

    <h1><a href="../index.php">Earthly</a></h1>

    <a href="../index.php">Retour à l'index</a>

    <h2>Connexion</h2>
    <form action="../form/form_connexion.php" method="POST">
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
    Ninbanight - mdp1
-->