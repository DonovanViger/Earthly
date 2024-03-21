<?php
        // Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté

        if (isset($_SESSION['pseudo'])) {
        ?>
<footer>
    <div class="nav">
        <div class="nav-slot round-top-left">
            <a href="../pages/defi.php" class="nav-link" id="defi">
                <img src="../img/nav bar/Defis noir.png" class="footer-image" data-image="1.png">
                <span class="image-text">Défis</span>
            </a>
        </div>
        <div class="nav-slot">
            <a href="../pages/recyclage.php" class="nav-link" id="recyclage">
                <img src="../img/nav bar/Scanner noir.png" class="footer-image" data-image="2.png">
                <span class="image-text">Recyclage</span>
            </a>
        </div>
        <div class="nav-slot curve">
            <a href="../pages/planet.php" class="floating-button" id="planet">
                <img src="../img/nav bar/home_noir.png" class="footer-image planet-icon" data-image="3.png">
            </a>
        </div>
        <div class="nav-slot">
            <a href="../pages/classement.php" class="nav-link" id="classement">
                <img src="../img/nav bar/Classement noir.png" class="footer-image" data-image="4.png">
                <span class="image-text">Classement</span>
            </a>
        </div>
        <div class="nav-slot round-top-right">
            <a href="../pages/compte.php" class="nav-link" id="compte">
                <img src="../img/nav bar/Profil noir.png" class="footer-image" data-image="5.png">
                <span class="image-text">Compte</span>
            </a>
        </div>
    </div>
</footer>


<?php
        }

?>

<script src="../script/pageactive.js"></script>