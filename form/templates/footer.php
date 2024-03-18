<?php
        // Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté

        if (isset($_SESSION['pseudo'])) {
        ?>
    <footer>
        <ul class="footer-nav">
        <li><a href="recyclage.php">Carte des poubelles</a></li>
        <li><a href="planet.php">Ma Planète</a></li>
        <li><a href="defi.php">Mes défis journaliers</a></li>
        <li><a href="classement.php">Classement</a></li>
        <li><a href="compte.php">Mon compte</a></li>
        </ul>
    </footer>
    <?php
        }

?>