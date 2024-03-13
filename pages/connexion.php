<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <title>Earthly | Connexion</title>
</head>
<body>
    




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

    <h1 id="h1_connexion"><a href="../index.php">Earthly</a></h1>

    

    <div id="connexion_cadre">
    <h2 id="h2_connexion">Connexion</h2>
    <form action="../form/form_connexion.php" method="POST">
        <label for="pseudo">Pseudo:</label><br>
        </br>
        <input type="text" id="pseudo" name="pseudo" required><br><br>
        <label for="mdp">Mot de passe:</label><br>
        </br>
        <input type="password" id="mdp" name="mdp" required><br><br>
        </br>
        <input type="submit" value="Se connecter">
    </form>
    </div>

<div id="connexion_retour">
    <button id="connexion_button_retour">
    <a href="../index.php">Retour à l'index</a>
    </button>
</div>

</body>

</html>

<!--
    Comptes : 
    AH - 1234
    admin - nice
    test - test
    Ninbanight - mdp1
-->