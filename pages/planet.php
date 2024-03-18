<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Earthly | Planète</title>
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

        // Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté

?>

<?php
        include("../form/templates/footer.php")
    ?>

</body>
</html>