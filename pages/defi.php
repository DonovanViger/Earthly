<?php
session_start();

if (!isset($_SESSION['pseudo'])) {
    header("Location: connexion.php");
    exit();
}

try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $date_actuelle = date('Y-m-d');

    $select_defis = $db->prepare("SELECT defiquotidien.ID_Defi, defis_journaliers.date, defiquotidien.nom, defiquotidien.pdd, defiquotidien.desc, defiquotidien.point FROM defis_journaliers INNER JOIN defiquotidien ON defis_journaliers.ID_Defi = defiquotidien.ID_Defi WHERE defis_journaliers.date = :date");
    $select_defis->bindParam(':date', $date_actuelle);
    $select_defis->execute();
    $defi_suppression = $db->prepare("DELETE FROM defis_journaliers WHERE date != :date");
    $defi_suppression->bindParam(':date', $date_actuelle);
    $defi_suppression->execute();
    $defi_utilisateur_suppression = $db->prepare("DELETE FROM utilisateursdefiquotidien WHERE dateObtention != :date");
    $defi_utilisateur_suppression->bindParam(':date', $date_actuelle);
    $defi_utilisateur_suppression->execute();
    $defis_journaliers = $select_defis->fetchAll(PDO::FETCH_ASSOC);

    $select_id = $db->prepare("SELECT ID_Utilisateur FROM utilisateurs WHERE ID_Utilisateur = :id_utilisateur");
    $select_id->bindParam(':id_utilisateur', $_SESSION['user_id']);
    $select_id->execute();
    $id_utilisateur = $select_id->fetchColumn();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['valider_defi'])) {
        $id_defi = $_POST['id_defi'];
        $sql = "SELECT * FROM `utilisateursdefiquotidien` WHERE `ID_Utilisateur` = $id_utilisateur AND `ID_Defi` = $id_defi AND `dateObtention` = '$date_actuelle'";
        $select_userDefi = $db->prepare($sql);
        $select_userDefi->execute();
        $defiuser = $select_userDefi->fetch();
        if (empty($defiuser)) {
            $update_defi = $db->prepare("INSERT INTO utilisateursdefiquotidien (ID_Utilisateur, ID_Defi, dateObtention) VALUES (:id_utilisateur, :id_defi, :date_obtention) ON DUPLICATE KEY UPDATE dateObtention = VALUES(dateObtention)");
            $update_defi->bindParam(':id_utilisateur', $id_utilisateur);
            $update_defi->bindParam(':id_defi', $_POST['id_defi']);
            $update_defi->bindParam(':date_obtention', $date_actuelle);
            $update_defi->execute();
            $update_score = $db->prepare("UPDATE utilisateurs INNER JOIN utilisateursdefiquotidien ON utilisateurs.ID_Utilisateur = utilisateursdefiquotidien.ID_Utilisateur INNER JOIN defiquotidien ON utilisateursdefiquotidien.ID_Defi = defiquotidien.ID_Defi SET utilisateurs.point_Planete = utilisateurs.point_Planete + defiquotidien.point, utilisateurs.exp_Utilisateur = utilisateurs.exp_Utilisateur + defiquotidien.point WHERE utilisateurs.ID_Utilisateur = :id_utilisateur");
            $update_score->bindParam(':id_utilisateur', $_SESSION['user_id']);
            $update_score->execute();
            if ($id_defi == 1) {
                $id_succes = 2;
                $id_succes2 = 4;
                $id_succes3 = 5;
            } else if ($id_defi == 2) {
                $id_succes = 8;
                $id_succes2 = 9;
                $id_succes3 = 10;
            } else if ($id_defi == 4) {
                $id_succes = 3;
                $id_succes2 = 6;
                $id_succes3 = 7;
            } else if ($id_defi == 5) {
                $id_succes = 16;
                $id_succes2 = 17;
                $id_succes3 = 18;
            } else {
                $id_succes = 19;
                $id_succes2 = 20;
                $id_succes3 = 21;
            } 
            $select_succes = $db->prepare("SELECT * FROM utilisateursucces INNER JOIN utilisateurs ON utilisateurs.ID_Utilisateur = utilisateursucces.ID_Utilisateur INNER JOIN succes ON succes.ID_Succes = utilisateursucces.ID_Succes WHERE utilisateursucces.ID_Succes = :id_succes AND utilisateurs.ID_Utilisateur = :id_utilisateur");
            $select_succes->bindParam(':id_succes', $id_succes);
            $select_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
            $select_succes->execute(); 
            $succesuser = $select_succes->fetch();
            if (empty($succesuser)) {
                $update_defi = $db->prepare("INSERT INTO utilisateursucces (ID_Utilisateur, ID_Succes, progression) VALUES (:id_utilisateur, :id_succes, 1)");
                $update_defi->bindParam(':id_utilisateur', $_SESSION['user_id']);
                $update_defi->bindParam(':id_succes', $id_succes);
                $update_defi->execute();
                $update_defi2 = $db->prepare("INSERT INTO utilisateursucces (ID_Utilisateur, ID_Succes, progression) VALUES (:id_utilisateur, :id_succes, 1)");
                $update_defi2->bindParam(':id_utilisateur', $_SESSION['user_id']);
                $update_defi2->bindParam(':id_succes', $id_succes2);
                $update_defi2->execute();
                $update_defi3 = $db->prepare("INSERT INTO utilisateursucces (ID_Utilisateur, ID_Succes, progression) VALUES (:id_utilisateur, :id_succes, 1)");
                $update_defi3->bindParam(':id_utilisateur', $_SESSION['user_id']);
                $update_defi3->bindParam(':id_succes', $id_succes3);
                $update_defi3->execute();
            } else if ($succesuser[4] != "1999-01-01") {
                $select_succes2 = $db->prepare("SELECT dateObtention FROM utilisateursucces WHERE ID_Succes = :id_succes2 AND ID_Utilisateur = :id_utilisateur");
                $select_succes2->bindParam(':id_succes2', $id_succes2);
                $select_succes2->bindParam(':id_utilisateur', $_SESSION['user_id']);
                $select_succes2->execute(); 
                $dateObtention2 = $select_succes2->fetch();
                if ($dateObtention2[0] != "1999-01-01") {
                    $select_succes2 = $db->prepare("SELECT dateObtention FROM utilisateursucces WHERE ID_Succes = :id_succes2 AND ID_Utilisateur = :id_utilisateur");
                    $select_succes2->bindParam(':id_succes2', $id_succes3);
                    $select_succes2->bindParam(':id_utilisateur', $_SESSION['user_id']);
                    $select_succes2->execute(); 
                    $dateObtention2 = $select_succes2->fetch();
                    if ($dateObtention2[0] != "1999-01-01") {
                    } else {
                        $update_succes = $db->prepare("UPDATE utilisateursucces SET progression = progression + 1 WHERE ID_Utilisateur = :id_utilisateur AND ID_Succes = :id_succes3");
                        $update_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
                        $update_succes->bindParam(':id_succes3', $id_succes3);
                        $update_succes->execute();
                        $select_progression_succes = $db->prepare("SELECT progression FROM utilisateursucces WHERE ID_Succes = :id_succes AND ID_Utilisateur = :id_utilisateur");
                        $select_progression_succes->bindParam(':id_succes', $id_succes3);
                        $select_progression_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
                        $select_progression_succes->execute(); 
                        $progression_actuel = $select_progression_succes->fetch();
                        $select_maxprogression_succes = $db->prepare("SELECT maxProgression FROM succes WHERE ID_Succes = :id_succes");
                        $select_maxprogression_succes->bindParam(':id_succes', $id_succes3);
                        $select_maxprogression_succes->execute(); 
                        $maxprogression_succes = $select_maxprogression_succes->fetch();
                        if ($progression_actuel[0] == $maxprogression_succes[0]) {
                            $dateActuel = date("Y-m-d");
                            $update_succes = $db->prepare("UPDATE utilisateursucces SET dateObtention = :dateActuel WHERE ID_Utilisateur = :id_utilisateur AND ID_Succes = :id_succes");
                            $update_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
                            $update_succes->bindParam(':id_succes', $id_succes3);
                            $update_succes->bindParam(':dateActuel', $dateActuel);
                            $update_succes->execute();
                        }
                    }
                } else {
                    $update_succes = $db->prepare("UPDATE utilisateursucces SET progression = progression + 1 WHERE ID_Utilisateur = :id_utilisateur AND ID_Succes = :id_succes2 OR ID_Succes = :id_succes3");
                    $update_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
                    $update_succes->bindParam(':id_succes2', $id_succes2);
                    $update_succes->bindParam(':id_succes3', $id_succes3);
                    $update_succes->execute();
                    $select_progression_succes = $db->prepare("SELECT progression FROM utilisateursucces WHERE ID_Succes = :id_succes AND ID_Utilisateur = :id_utilisateur");
                    $select_progression_succes->bindParam(':id_succes', $id_succes2);
                    $select_progression_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
                    $select_progression_succes->execute(); 
                    $progression_actuel = $select_progression_succes->fetch();
                    $select_maxprogression_succes = $db->prepare("SELECT maxProgression FROM succes WHERE ID_Succes = :id_succes");
                    $select_maxprogression_succes->bindParam(':id_succes', $id_succes2);
                    $select_maxprogression_succes->execute(); 
                    $maxprogression_succes = $select_maxprogression_succes->fetch();
                    if ($progression_actuel[0] == $maxprogression_succes[0]) {
                        $dateActuel = date("Y-m-d");
                        $update_succes = $db->prepare("UPDATE utilisateursucces SET dateObtention = :dateActuel WHERE ID_Utilisateur = :id_utilisateur AND ID_Succes = :id_succes");
                        $update_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
                        $update_succes->bindParam(':id_succes', $id_succes2);
                        $update_succes->bindParam(':dateActuel', $dateActuel);
                        $update_succes->execute();
                    }
                }
            } else {
                $update_succes = $db->prepare("UPDATE utilisateursucces SET progression = progression + 1 WHERE ID_Utilisateur = :id_utilisateur AND ID_Succes = :id_succes OR ID_Succes = :id_succes2 OR ID_Succes = :id_succes3");
                $update_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
                $update_succes->bindParam(':id_succes', $id_succes);
                $update_succes->bindParam(':id_succes2', $id_succes2);
                $update_succes->bindParam(':id_succes3', $id_succes3);
                $update_succes->execute();
                $select_progression_succes = $db->prepare("SELECT progression FROM utilisateursucces WHERE ID_Succes = :id_succes AND ID_Utilisateur = :id_utilisateur");
                $select_progression_succes->bindParam(':id_succes', $id_succes);
                $select_progression_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
                $select_progression_succes->execute(); 
                $progression_actuel = $select_progression_succes->fetch();
                $select_maxprogression_succes = $db->prepare("SELECT maxProgression FROM succes WHERE ID_Succes = :id_succes");
                $select_maxprogression_succes->bindParam(':id_succes', $id_succes);
                $select_maxprogression_succes->execute(); 
                $maxprogression_succes = $select_maxprogression_succes->fetch();
                if ($progression_actuel[0] == $maxprogression_succes[0]) {
                    $dateActuel = date("Y-m-d");
                    $update_succes = $db->prepare("UPDATE utilisateursucces SET dateObtention = :dateActuel WHERE ID_Utilisateur = :id_utilisateur AND ID_Succes = :id_succes");
                    $update_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
                    $update_succes->bindParam(':id_succes', $id_succes);
                    $update_succes->bindParam(':dateActuel', $dateActuel);
                    $update_succes->execute();
                }
            }

        }
    }        
} catch (PDOException $erreur) {
    die("Erreur de connexion à la base de données : " . $erreur->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/" href="../img2/Fichier 27.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Défis</title>
    <style>
        
        .defi{
            text-align:center;
        }
        .defi strong{
            color:#2BBA7C;
            font-size:5.5vw;
            float:right;
            width: 60%;
            margin-left : 1vw;
            margin-top:3vh;
            padding:2vh;
        }
        .defi img{
            margin:3vh 0 3vh 5vw;
            width:30%;
        }

        #defis_button{
            width:80%;
            margin:2vh 0 0 0;
            padding:1vh;
            background-color:#1C3326;
            color:#FFEFE1;
            border-radius:15px;
            border: none;
        }
    </style>
</head>

<body>

    <div id="defi_patern_box">

    <div id="defi_title_box">
    <img src="../img/DEFIS.svg" alt="épingle" id="defi_epingle_img">
    

    <a href="../index.html" id="defis_h1_a"><img src="../img/earthly_defis.png" alt="logo défis" id="défis_logo"></a>

</div>

<div id="defis_communautaire_box">
<img src="../img/people.svg" alt="people icon" id="defis_communautaire_people">
<h2 id="defis_communautaire_h2">Les défis communautaires</h2>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6" id="defis_communautaire_chevron">
  <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
</svg>

</div>
    <?php
    if (!empty($defis_journaliers)) {
        echo "<ul id='defis_ul'>";
        foreach ($defis_journaliers as $defi) {
            echo "<div class='defi'>";
            echo "<img src = '",$defi['pdd'],"' alt='",$defi['nom'],"'><strong>", $defi['nom'], "</strong> </br> ", $defi['desc'];
            echo "<form method='POST' action='defi.php' id='defi_form'>";
            echo "<input type='hidden' name='id_defi' value='" . $defi['ID_Defi'] . "'>";
            $id_defi = $defi['ID_Defi'];
            $sql = "SELECT * FROM `utilisateursdefiquotidien` WHERE `ID_Utilisateur` = $id_utilisateur AND `ID_Defi` = $id_defi AND `dateObtention` = '$date_actuelle'";
            $select_userDefi = $db->prepare($sql);
            $select_userDefi->execute();
            $defiuser = $select_userDefi->fetch();
            if (!empty($defiuser)) {
                echo "<div id='defis_reussi'>Defi Reussi !</div>";
            } else {
                echo "<button type='submit' name='valider_defi' id='defis_button'>Valider</button>";
            }

            echo "</form>";
            echo "<h3 id='defis_xp_ajout'>+".$defi['point']."px</h3>";
            echo "</div>";
        }
        echo "</ul>";
    } else {
        echo "<div id='defis_rafraichir_defis'><a href='defi.php'>Rafraîchir la page pour voir les defis</a></div>";
        $requete_defis = $db->query("SELECT * FROM defiquotidien ORDER BY RAND() LIMIT 3");
        $defis_selectionnes = $requete_defis->fetchAll(PDO::FETCH_ASSOC);

        $insert_defis = $db->prepare("INSERT INTO defis_journaliers (ID_Defi, date) VALUES (:id_defi, :date)");
        foreach ($defis_selectionnes as $defi) {
            $insert_defis->bindParam(':id_defi', $defi['ID_Defi']);
            $insert_defis->bindParam(':date', $date_actuelle);
            $insert_defis->execute();
        }
    }


$requete = $db->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo");
$requete->bindParam(':pseudo', $_SESSION['pseudo']);
$requete->execute();

$utilisateur = $requete->fetch(PDO::FETCH_ASSOC);
    
    $pointsUtilisateur = $utilisateur['point_Planete'];
    $pointsNiveauSuivant = 1000;

                if ($pointsUtilisateur >= 1000 && $pointsUtilisateur < 3000) {
                    $niveauActuel = 2;
                    $pointsNiveauSuivant = 2000;
                    $pointsUtilisateur = $pointsUtilisateur - 1000;
                } elseif ($pointsUtilisateur >= 3000 && $pointsUtilisateur < 7000) {
                    $niveauActuel = 3;
                    $pointsNiveauSuivant = 4000;
                    $pointsUtilisateur = $pointsUtilisateur - 3000;
                } elseif ($pointsUtilisateur >= 7000 && $pointsUtilisateur < 15000) {
                    $niveauActuel = 4;
                    $pointsNiveauSuivant = 8000;
                    $pointsUtilisateur = $pointsUtilisateur - 7000;
                } elseif ($pointsUtilisateur >= 15000) {
                    $niveauActuel = 5;
                    $pointsNiveauSuivant = null;
                }

                        $progression = ($pointsUtilisateur / $pointsNiveauSuivant) * 100;
    ?>

<div id="defis_button_succes_box">
<a href="success.php">Voir mes succès</a>
</div>

<div id="defis_xp_bar">
<?php
echo "<h3 id='defis_h3_bar_ex'>".$pointsUtilisateur."xp</h3>";
echo "<h3 id='defis_h3_bar_lv'>".$pointsNiveauSuivant."</h3>";
?>
<br>
<div class="progress">
    <div class="progress-bar" role="progressbar" style="width: <?= $progression ?>%;" aria-valuenow="<?= $progression ?>" aria-valuemin="0" aria-valuemax="100"></div>
  </div>
</div>
</div>
    <?php
        include("../form/templates/footer.php")
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
        var A = document.getElementsByClassName("defi");
        console.log(A);
        A[1].style.backgroundColor = "#2BBA7C";
        A[2].style.backgroundColor = "#2BBA7C";
        A[1].style.width = "42.5vw";
        A[2].style.width = "42.5vw";
        A[1].style.float = "left";
        A[2].style.float = "left";
        A[1].style.margin = "0 0 5vh 5vw";
        A[2].style.margin = "0 0 5vh 5vw";
        A[1].children[1].style.color = "#1C3326";
        A[2].children[1].style.color = "#1C3326";
        A[0].children[4].style.margin = "2vh 0 0 0";

        A[1].style.color = "#A9FFA4";
        A[2].style.color = "#A9FFA4";
        A[1].style.fontSize = "1.5vh";
        A[2].style.fontSize = "1.5vh";

        A[1].children[0].style.width = "10vh";
        A[1].children[0].style.height = "10vh";
        A[1].children[0].style.margin = "2vh 0 0 0";

        A[2].children[0].style.width = "10vh";
        A[2].children[0].style.height = "10vh";
        A[2].children[0].style.margin = "2vh 0 0 0";

        A[1].children[1].style.width = "100%";
        A[1].children[1].style.margin = "0";
        A[1].children[1].style.fontSize = "2vh";

        A[2].children[1].style.width = "100%";
        A[2].children[1].style.margin = "0";
        A[2].children[1].style.fontSize = "2vh";


        A[1].children[3].style.margin = "0 0 2vh 0";
        A[2].children[3].style.margin = "0 0 2vh 0";




    </script>

</body>

</html>