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
    <?php
        // Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté
        if(!isset($_SESSION['pseudo'])) {
            ?>
            <li><a href="pages/connexion.php">Se connecter</a></li>
            <li><a href="pages/inscription.php">Créer un compte</a></li>
            <?php
        }
        ?>
        <li><a href="pages/planet.php">Ma Planète</a></li>
        <li><a href="pages/defi.php">Mes défis journaliers</a></li>
        <li><a href="pages/recyclage.php">Carte des poubelles</a></li>
        <li><a href="pages/compte.php">Mon compte</a></li>
    </ul>
    
    <a href="form/deconnexion.php">Se déconnecter</a>
</body>
</html>
