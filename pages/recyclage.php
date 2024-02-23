<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Mon compte</title>
</head>
<body>

<?php

session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if(!isset($_SESSION['pseudo'])) {
    // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erreur) {
    die("Erreur de connexion à la base de données : ". $erreur->getMessage());
}

?>


<h1>Recyclez avec nos poubelles intelligentes</h1>

<?php
        // Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté
        if (isset($_SESSION['pseudo'])) {
        ?>
        <ul class="footer-nav">
            <li><a href="planet.php">Ma Planète</a></li>
            <li><a href="defi.php">Mes défis journaliers</a></li>
            <li><a href="recyclage.php">Carte des poubelles</a></li>
            <li><a href="compte.php">Mon compte</a></li>
            <li><a href="classement.php">Classement</a></li>
        </ul>
<?php
        }

?>
</body>
</html>