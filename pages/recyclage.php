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
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d41508.59898682105!2d1.0499719745870364!3d49.44128414307138!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e0de76ca71faab%3A0x3d1cabefa49f93d6!2sRouen!5e0!3m2!1sfr!2sfr!4v1708439062394!5m2!1sfr!2sfr" width="1000" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

<?php
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