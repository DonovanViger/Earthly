<?php
session_start(); // Démarre la session (à placer au début de chaque fichier PHP où vous utilisez des sessions)

// Vérifie si l'utilisateur est connecté
if(isset($_SESSION['pseudo'])) {
    $pseudo = $_SESSION['pseudo'];
    echo "Bienvenue, $pseudo!";
    // Affiche le reste de votre contenu pour les utilisateurs connectés
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Earthly</title>
</head>
<body>

    <h1>Earthly</h1>
    <h2>Care for the world</h2>
    <ul>
        <li><a href="connexion.php">Se connecter</a></li>
        <li><a href="inscription.php">Créer un compte</a></li>
        <li><a href="planet.php">Ma Planète</a></li>
        <li><a href="defi.php">Mes défis journaliers</a></li>
        <li><a href="recyclage.php">Carte des poubelles</a></li>
        <li><a href="compte.php">Mon compte</a></li>
    </ul>
    
    <a href="form/deconnexion.php">Se déconnecter</a>
</body>
</html>
