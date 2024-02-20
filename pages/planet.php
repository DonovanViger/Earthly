<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erreur) {
    die("Erreur de connexion à la base de données : ". $erreur->getMessage());
}

        // Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté


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