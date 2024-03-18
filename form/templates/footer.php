<?php
        // Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté

        if (isset($_SESSION['pseudo'])) {
        ?>
    <footer>
        <ul class="footer-nav">
        <li><a href="../pages/recyclage.php">Carte des poubelles</a></li>
        <li><a href="../pages/planet.php">Ma Planète</a></li>
        <li><a href="../pages/defi.php">Mes défis journaliers</a></li>
        <li><a href="../pages/classement.php">Classement</a></li>
        <li><a href="../pages/compte.php">Mon compte</a></li>
        </ul>
    </footer>
    <?php
        }

?>