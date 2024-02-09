<?php
try {
    // Connexion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer les défis
    $requete = $db->query("SELECT * FROM defis ORDER BY ID_Defi");

    // Affichage des défis
    echo "<h1>Liste des défis</h1>";
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
?>
