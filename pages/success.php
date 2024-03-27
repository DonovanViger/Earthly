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

    foreach ($succesuser as $succesnumber) {
        if ($succesnumber[1] != "1999-01-01"){
            $tableau[$succesnumber[0]]="oui";
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
    <h2 id="success_h2_1">Petite branche</h2>

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
    <p class="success_paragraph_descrip_darkgreen">Avoir créer son compte | Être membre depuis 1 mois | Être membre depuis 1 an</p>
    </div>

    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Petite branche <strong class="succes_strong_green">I</strong></h3>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[1] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Petite branche <strong class="succes_strong_green">II</strong></h3>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[14] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Petite branche <strong class="succes_strong_green">III</strong></h3>
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
    <h2 id="success_h2_2">De feuille en feuille</h2>
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
    <p class="success_paragraph_descrip_darkgreen">Réaliser le défi quotidien "De feuille à feuille" 5 fois <br>20 fois <br>100 fois</p>
    </div>

    <div class="success_box_2">
        <h3 class="success_h3_lightgreen">De feuille en feuille <strong class="succes_strong_green">I</strong></h3>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[2] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
    <div class="success_box_2">
        <h3 class="success_h3_lightgreen">De feuille en feuille <strong class="succes_strong_green">II</strong></h3>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[4] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
    <div class="success_box_2">
        <h3 class="success_h3_lightgreen">De feuille en feuille <strong class="succes_strong_green">III</strong></h3>
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
    <p class="success_paragraph_descrip_white">rgsrhhherhg</p>
    </div>

    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Eco-safari urbain <strong class="succes_strong_green">I</strong></h3>
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[7] == "oui") {
                echo "checked";
            }
            ?>>
        </div>
    </div>
    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Eco-safari urbain <strong class="succes_strong_green">II</strong></h3>
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
        <div class="succes_checkbox">
            <input type="checkbox" disabled <?php 
            if ($tableau[3] == "oui") {
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
    <p class="success_paragraph_descrip_darkgreen">rgsrhhherhg</p>
    </div>

    <div class="success_box_3">
        <h3 class="success_h3_lightgreen">Douche éclair <strong class="succes_strong_lightergreen">I</strong></h3>
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
    <p class="success_paragraph_descrip_lightgreen">rgsrhhherhg</p>
    </div>

    <div class="success_box_1">
        <h3 class="success_h3_darkgreen">Seconde vie <strong class="succes_strong_lightergreen">I</strong></h3>
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
    <p class="success_paragraph_descrip_darkgreen">rgsrhhherhg</p>
    </div>

    <div class="success_box_3">
        <h3 class="success_h3_lightgreen">Dépense Fruitière <strong class="succes_strong_lightergreen">I</strong></h3>
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