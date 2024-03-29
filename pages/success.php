<?php
session_start();

if (!isset($_SESSION['pseudo'])) {
    header("Location: connexion.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/" href="../img2/Fichier 27.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Earthly | Succès</title>
</head>
<body>
    <?php
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $select_succes_user = $db->prepare("SELECT ID_Succes, progression, dateObtention FROM utilisateursucces where ID_Utilisateur=:id_utilisateur");
    $select_succes_user->bindParam(':id_utilisateur', $_SESSION['user_id']);
    $select_succes_user->execute();
    $succesuser = $select_succes_user->fetchAll();
    $tableau = [1 => "", 2 => "", 3 => "", 4 => "", 5 => "", 6 => "", 7 => "", 8 => "", 9 => "", 10 => "", 14 => "", 15 => "", 16 => "", 17 => "", 18 => "", 19 => "", 20 => "", 21 => "", ];

    foreach ($succesuser as $succesnumber) {
        if ($succesnumber[2] != "1999-01-01"){
            $tableau[$succesnumber[0]]="oui";
        } else if (isset($succesnumber[2])){
            $tableau[$succesnumber[0]]=$succesnumber[1];
            intval($tableau[$succesnumber[0]]);
        }
    }

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
    <h2 id="success_h2_1">Jeune branche</h2>

    <div id="success_number_lightgreen">
        <?php 
        if ($tableau[15] == "oui") {
            echo "3/3";
        } else if ($tableau[14] == "oui") {
            echo "2/3";
        } else if ($tableau[1] == "oui") {
            echo "1/3";
        } else {
            echo "0/3";
        }
        ?>
    </div>

    <div class="success_descript_box">
    <p class="success_paragraph_descrip_lightgreen">Avoir créer son compte <br>Être membre depuis 1 mois <br>Être membre depuis 1 an</p>
    </div>

    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Jeune branche <strong class="succes_strong_green">I</strong></h3>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[1] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Jeune branche <strong class="succes_strong_green">II</strong></h3>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[14] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Jeune branche <strong class="succes_strong_green">III</strong></h3>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[15] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
</div>

<div id="succes_box2">
    <img src="../img/trophy-dark.svg" alt="trophy" id="success_svg_trophy">
    <h2 id="success_h2_2">De feuille à feuille</h2>
    <div id="success_number_green">
        <?php 
        if ($tableau[5] == "oui") {
            echo "3/3";
        } else if ($tableau[4] == "oui") {
            echo "2/3";
        } else if ($tableau[2] == "oui") {
            echo "1/3";
        } else {
            echo "0/3";
        }
        ?>
    </div>
    
    <div class="success_descript_box">
    <p class="success_paragraph_descrip_darkgreen">Réaliser le défi "De feuille à feuille"<br>5 fois | 20 fois | 100 fois</p>
    </div>

    <div class="success_box_2">
        <h3 class="success_h3_lightgreen">De feuille à feuille <strong class="succes_strong_green">I</strong></h3>
        <div class="success_advencement_lightgreen"><?php if ($tableau[2] == "oui") {
            echo "100%";
        } else if (isset($tableau[2])) {
            $calcul = intval($tableau[2])*20;
            echo $calcul."%";
        } else {
            echo "0%";
        }
         ?></div>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[2] == "oui") {
                echo "checked";
            } 
            ?>>
        </div>
    </div>
    <div class="success_box_2">
        <h3 class="success_h3_lightgreen">De feuille à feuille <strong class="succes_strong_green">II</strong></h3>
        <div class="success_advencement_lightgreen"><?php if ($tableau[4] == "oui") {
            echo "100%";
        } else if (isset($tableau[4])) {
            $calcul = intval($tableau[4])*5;
            echo $calcul."%";
        } else {
            echo "0%";
        }
         ?></div>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[4] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
    <div class="success_box_2">
        <h3 class="success_h3_lightgreen">De feuille à feuille <strong class="succes_strong_green">III</strong></h3>
        <div class="success_advencement_lightgreen"><?php if ($tableau[5] == "oui") {
            echo "100%";
        } else if (isset($tableau[5])) {
            $calcul = intval($tableau[5]);
            echo $calcul."%";
        } else {
            echo "0%";
        }
         ?></div>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[5] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
</div>


<div id="succes_box3">
<img src="../img/trophy-white.svg" alt="trophy" id="success_svg_trophy">
    <h2 id="success_h2_3">Eco-safari urbain</h2>
    <div id="success_number_white">
        <?php 
        if ($tableau[7] == "oui") {
            echo "3/3";
        } else if ($tableau[6] == "oui") {
            echo "2/3";
        } else if ($tableau[3] == "oui") {
            echo "1/3";
        } else {
            echo "0/3";
        }
        ?>
    </div>

    <div class="success_descript_box">
    <p class="success_paragraph_descrip_white">Réaliser le défi "Eco-safari urbain"<br>5 fois | 20 fois | 100 fois</p>
    </div>

    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Eco-safari urbain <strong class="succes_strong_green">I</strong></h3>
        <div class="success_advencement_darkgreen"><?php if ($tableau[3] == "oui") {
            echo "100%";
        } else if (isset($tableau[3])) {
            $calcul = intval($tableau[3])*20;
            echo $calcul."%";
        } else {
            echo "0%";
        }
         ?></div>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[3] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Eco-safari urbain <strong class="succes_strong_green">II</strong></h3>
        <div class="success_advencement_darkgreen"><?php if ($tableau[6] == "oui") {
            echo "100%";
        } else if (isset($tableau[6])) {
            $calcul = intval($tableau[6])*5;
            echo $calcul."%";
        } else {
            echo "0%";
        }
         ?></div>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[6] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Eco-safari urbain <strong class="succes_strong_green">III</strong></h3>
        <div class="success_advencement_darkgreen"><?php if ($tableau[7] == "oui") {
            echo "100%";
        } else if (isset($tableau[7])) {
            $calcul = intval($tableau[7]);
            echo $calcul."%";
        } else {
            echo "0%";
        }
         ?></div>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[7] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
</div>


<div id="succes_box4">
<img src="../img/trophy-dark.svg" alt="trophy" id="success_svg_trophy">
    <h2 id="success_h2_2">Douche éclair</h2>
    <div id="success_number_green">
        <?php 
        if ($tableau[10] == "oui") {
            echo "3/3";
        } else if ($tableau[9] == "oui") {
            echo "2/3";
        } else if ($tableau[8] == "oui") {
            echo "1/3";
        } else {
            echo "0/3";
        }
        ?>
    </div>

    <div class="success_descript_box">
    <p class="success_paragraph_descrip_darkgreen">Réaliser le défi "Douche éclair"<br>5 fois | 20 fois | 100 fois</p>
    </div>

    <div class="success_box_3">
        <h3 class="success_h3_lightgreen">Douche éclair <strong class="succes_strong_lightergreen">I</strong></h3>
        <div class="success_advencement_lightgreen"><?php if ($tableau[8] == "oui") {
            echo "100%";
        } else if (isset($tableau[8])) {
            $calcul = intval($tableau[8])*20;
            echo $calcul."%";
        } else {
            echo "0%";
        }
         ?></div>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[8] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
    <div class="success_box_3">
        <h3 class="success_h3_lightgreen">Douche éclair <strong class="succes_strong_lightergreen">II</strong></h3>
        <div class="success_advencement_lightgreen"><?php if ($tableau[9] == "oui") {
            echo "100%";
        } else if (isset($tableau[9])) {
            $calcul = intval($tableau[9])*5;
            echo $calcul."%";
        } else {
            echo "0%";
        }
         ?></div>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[9] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
    <div class="success_box_3">
        <h3 class="success_h3_lightgreen">Douche éclair <strong class="succes_strong_lightergreen">III</strong></h3>
        <div class="success_advencement_lightgreen"><?php if ($tableau[10] == "oui") {
            echo "100%";
        } else if (isset($tableau[10])) {
            $calcul = intval($tableau[10]);
            echo $calcul."%";
        } else {
            echo "0%";
        }
         ?></div>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[10] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
</div>


<div id="succes_box5">
<img src="../img/trophy.svg" alt="trophy" id="success_svg_trophy">
    <h2 id="success_h2_1">Seconde vie</h2>
    <div id="success_number_lightgreen">
        <?php 
        if ($tableau[18] == "oui") {
            echo "3/3";
        } else if ($tableau[17] == "oui") {
            echo "2/3";
        } else if ($tableau[16] == "oui") {
            echo "1/3";
        } else {
            echo "0/3";
        }
        ?>
    </div>

    <div class="success_descript_box">
    <p class="success_paragraph_descrip_lightgreen">Réaliser le défi "Seconde vie"<br>5 fois | 20 fois | 100 fois</p>
    </div>

    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Seconde vie <strong class="succes_strong_lightergreen">I</strong></h3>
        <div class="success_advencement_darkgreen"><?php if ($tableau[16] == "oui") {
            echo "100%";
        } else if (isset($tableau[16])) {
            $calcul = intval($tableau[16])*20;
            echo $calcul."%";
        } else {
            echo "0%";
        }
         ?></div>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[16] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Seconde vie <strong class="succes_strong_lightergreen">II</strong></h3>
        <div class="success_advencement_darkgreen"><?php if ($tableau[17] == "oui") {
            echo "100%";
        } else if (isset($tableau[17])) {
            $calcul = intval($tableau[17])*5;
            echo $calcul."%";
        } else {
            echo "0%";
        }
         ?></div>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[17] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Seconde vie <strong class="succes_strong_lightergreen">III</strong></h3>
        <div class="success_advencement_darkgreen"><?php if ($tableau[18] == "oui") {
            echo "100%";
        } else if (isset($tableau[18])) {
            $calcul = intval($tableau[18]);
            echo $calcul."%";
        } else {
            echo "0%";
        }
         ?></div>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[18] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
</div>


<div id="succes_box6">
<img src="../img/trophy-dark.svg" alt="trophy" id="success_svg_trophy">
    <h2 id="success_h2_2">Dépense Fruitière</h2>
    <div id="success_number_green">
        <?php 
        if ($tableau[21] == "oui") {
            echo "3/3";
        } else if ($tableau[20] == "oui") {
            echo "2/3";
        } else if ($tableau[19] == "oui") {
            echo "1/3";
        } else {
            echo "0/3";
        }
        ?>
    </div>

    <div class="success_descript_box">
    <p class="success_paragraph_descrip_darkgreen">Réaliser le défi "Dépense Fruitière"<br>5 fois | 20 fois | 100 fois</p>
    </div>

    <div class="success_box_3">
        <h3 class="success_h3_lightgreen">Dépense Fruitière <strong class="succes_strong_lightergreen">I</strong></h3>
        <div class="success_advencement_lightgreen"><?php if ($tableau[19] == "oui") {
            echo "100%";
        } else if (isset($tableau[19])) {
            $calcul = intval($tableau[19])*20;
            echo $calcul."%";
        } else {
            echo "0%";
        }
         ?></div>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[19] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
    <div class="success_box_3">
        <h3 class="success_h3_lightgreen">Dépense Fruitière <strong class="succes_strong_lightergreen">II</strong></h3>
        <div class="success_advencement_lightgreen"><?php if ($tableau[20] == "oui") {
            echo "100%";
        } else if (isset($tableau[20])) {
            $calcul = intval($tableau[20])*5;
            echo $calcul."%";
        } else {
            echo "0%";
        }
         ?></div>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[20] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
    <div class="success_box_3">
        <h3 class="success_h3_lightgreen">Dépense Fruitière <strong class="succes_strong_lightergreen">III</strong></h3>
        <div class="success_advencement_lightgreen"><?php if ($tableau[21] == "oui") {
            echo "100%";
        } else if (isset($tableau[21])) {
            $calcul = intval($tableau[21]);
            echo $calcul."%";
        } else {
            echo "0%";
        }
         ?></div>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[21] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
</div>
</div>

<?php
    include ("../form/templates/footer.php")
        ?>
</body>
</html>