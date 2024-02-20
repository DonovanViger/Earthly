<?php

session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if(!isset($_SESSION['pseudo'])) {
    // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Défis</title>
</head>
<body>

<h1><a href="../index.php">Earthly</a></h1>

<?php

try {
    // Connexion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer les défis
    $requete = $db->query("SELECT * FROM defiquotidien ORDER BY ID_Defi");

    // Affichage des défis
    echo "<h2>Liste des défis</h2>";
    echo "<ul>";
    while ($defi = $requete->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>";
        echo "<strong>",$defi['nom'],"</strong>: ", $defi['desc'];
        echo "</li>";
    }
    echo "</ul>";
} catch (PDOException $erreur) {
    // En cas d'erreur de connexion à la base de données
    die("Erreur de connexion à la base de données : ". $erreur->getMessage());
}

// Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté

if (isset($_SESSION['pseudo'])) {
?>
    <li><a href="planet.php">Ma Planète</a></li>
    <li><a href="defi.php">Mes défis journaliers</a></li>
    <li><a href="recyclage.php">Carte des poubelles</a></li>
    <li><a href="compte.php">Mon compte</a></li>
</ul>
<?php
}

?>

</body>
</html>
