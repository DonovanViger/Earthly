<?php
        // Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté

        if (isset($_SESSION['pseudo'])) {
        ?>
<footer>
    <ul class="footer-nav">
        <li><i class="fa-solid fa-qrcode"></i><a href="../pages/recyclage.php">Scanner</a></li>
        <li><i class="fa-solid fa-earth-europe"></i><a href="../pages/planet.php">Planète</a></li>
        <li><i class="fa-solid fa-trophy"></i><a href="../pages/defi.php">Défis journaliers</a></li>
        <li><i class="fa-solid fa-medal"></i><a href="../pages/classement.php">Classement</a></li>
        <li><i class="fa-solid fa-user"></i><a href="../pages/compte.php">Compte</a></li>
    </ul>
</footer>
<?php
        }

?>