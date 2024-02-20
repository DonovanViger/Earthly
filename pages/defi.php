<?php
try {
    // Connexion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer les défis
    $requete = $db->query("SELECT * FROM defiquotidien ORDER BY ID_Defi");

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

// Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté
if (!isset($_SESSION['pseudo'])) {
?>
    <li><a href="pages/connexion.php">Se connecter</a></li>
    <li><a href="pages/inscription.php">Créer un compte</a></li>
<?php
}

if (isset($_SESSION['pseudo'])) {
?>
    <li><a href="pages/planet.php">Ma Planète</a></li>
    <li><a href="pages/defi.php">Mes défis journaliers</a></li>
    <li><a href="pages/recyclage.php">Carte des poubelles</a></li>
    <li><a href="pages/compte.php">Mon compte</a></li>
    <li><a href="form/deconnexion.php">Se déconnecter</a></li>
</ul>
<?php
}

?>
