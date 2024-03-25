<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['pseudo'])) {
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
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Earthly | Succès</title>
</head>
<body>
    <?php
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $select_succes_user = $db->prepare("SELECT ID_Succes, dateObtention FROM utilisateursucces where ID_Utilisateur=:id_utilisateur");
    $select_succes_user->bindParam(':id_utilisateur', $_SESSION['user_id']);
    $select_succes_user->execute();
    $succesuser = $select_succes_user->fetchAll();
    $tableau = [1 => "", 2 => "", 3 => "", 4 => "", 5 => "", 6 => "", 7 => "", 8 => "", 9 => "", 10 => "", 14 => "", 15 => "", 16 => "", 17 => "", 18 => "", 19 => "", 20 => "", 21 => "", ];

    echo "<script> console.table(".json_encode($succesuser).");</script>";
    echo "<script> console.table(".json_encode($tableau).");</script>";

    $nn = 1;
    foreach ($succesuser as $succesnumber) {
        echo "<script> console.log(".json_encode($succesnumber[1]).");</script>";
        if ($succesnumber[1] != "0000-00-00"){
            $tableau[$nn]="oui";
        }
        $nn++;
    }

    echo "<script> console.table(".json_encode($tableau).");</script>";
    ?>

    <div id="success_overall">
        <div id="success_title_box">
        <a href="defi.php">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="#A9FFA4" class="w-6 h-6" id="success_svg_retour">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
        </svg>
    </a>
    <h1 id="success_h1">Mes succès</h1>
</div>

    <div id="succes_box1">
    <img src="../img/trophy.svg" alt="trophy" id="success_svg_trophy">
    <h2 id="success_h2_1">Petite branche</h2>
    <div id="success_number">
        <?php 
        ?>
    </div>

    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Petite branche <strong class="succes_strong_green">I</strong></h3>
        <div class="succes_checkbox"></div>
    </div>
    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Petite branche <strong class="succes_strong_green">II</strong></h3>
        <div class="succes_checkbox"></div>
    </div>
    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Petite branche <strong class="succes_strong_green">III</strong></h3>
        <div class="succes_checkbox"></div>
    </div>
</div>

<div id="succes_box2">
    <img src="../img/trophy-dark.svg" alt="trophy" id="success_svg_trophy">
    <h2 id="success_h2_2">De feuille en feuille</h2>
    <div id="success_number"></div>
    

    <div class="success_box_2">
        <h3 class="success_h3_lightgreen">De feuille en feuille <strong class="succes_strong_green">I</strong></h3>
        <div class="succes_checkbox"></div>
    </div>
    <div class="success_box_2">
        <h3 class="success_h3_lightgreen">De feuille en feuille <strong class="succes_strong_green">II</strong></h3>
        <div class="succes_checkbox"></div>
    </div>
    <div class="success_box_2">
        <h3 class="success_h3_lightgreen">De feuille en feuille <strong class="succes_strong_green">III</strong></h3>
        <div class="succes_checkbox"></div>
    </div>
</div>


<div id="succes_box3">
<img src="../img/trophy-white.svg" alt="trophy" id="success_svg_trophy">
    <h2 id="success_h2_3">Douche éclair</h2>
    <div id="success_number"></div>

    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Douche éclair <strong class="succes_strong_green">I</strong></h3>
        <div class="succes_checkbox"></div>
    </div>
    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Douche éclair <strong class="succes_strong_green">II</strong></h3>
        <div class="succes_checkbox"></div>
    </div>
    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Douche éclair <strong class="succes_strong_green">III</strong></h3>
        <div class="succes_checkbox"></div>
    </div>
</div>


<div id="succes_box4">
<img src="../img/trophy-dark.svg" alt="trophy" id="success_svg_trophy">
    <h2 id="success_h2_2">Douche éclair</h2>
    <div id="success_number"></div>

    <div class="success_box_3">
        <h3 class="success_h3_lightgreen">Douche éclair <strong class="succes_strong_lightergreen">I</strong></h3>
        <div class="succes_checkbox"></div>
    </div>
    <div class="success_box_3">
        <h3 class="success_h3_lightgreen">Douche éclair <strong class="succes_strong_lightergreen">II</strong></h3>
        <div class="succes_checkbox"></div>
    </div>
    <div class="success_box_3">
        <h3 class="success_h3_lightgreen">Douche éclair <strong class="succes_strong_lightergreen">III</strong></h3>
        <div class="succes_checkbox"></div>
    </div>
</div>


</body>
</html>