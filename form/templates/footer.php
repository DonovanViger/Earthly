<?php
        // Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté

        if (isset($_SESSION['pseudo'])) {
        ?>
<footer>
    <div class="nav">
        <div class="nav-slot round-top-left">
            <a href="../pages/defi.php" class="nav-link" id="defi">
                <i class="fa-solid fa-trophy"></i>
            </a>
        </div>
        <div class="nav-slot">
            <a href="../pages/recyclage.php" class="nav-link" id="recyclage">
                <i class="fa-solid fa-qrcode"></i>
            </a>
        </div>
        <div class="nav-slot curve">
            <a href="../pages/planet.php" class="floating-button" id="planet">
                <i class="fa-solid fa-earth-europe"></i>
            </a>
        </div>
        <div class="nav-slot">
            <a href="../pages/classement.php" class="nav-link" id="classement">
                <i class="fa-solid fa-medal"></i>
            </a>
        </div>
        <div class="nav-slot round-top-right">
            <a href="../pages/compte.php" class="nav-link" id="compte">
                <i class="fa-solid fa-user"></i>
            </a>
        </div>
    </div>
</footer>


<?php
        }

?>

<script src="../script/pageactive.js"></script>