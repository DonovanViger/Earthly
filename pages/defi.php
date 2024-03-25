<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['pseudo'])) {
    // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

try {
    // Connexion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $date_actuelle = date('Y-m-d');

    // Vérification si des défis sont sélectionnés pour la journée actuelle
    $stmt_select_defis = $db->prepare("SELECT defiquotidien.ID_Defi, defis_journaliers.date, defiquotidien.nom, defiquotidien.desc FROM defis_journaliers INNER JOIN defiquotidien ON defis_journaliers.ID_Defi = defiquotidien.ID_Defi WHERE defis_journaliers.date = :date");
    $stmt_select_defis->bindParam(':date', $date_actuelle);
    $stmt_select_defis->execute();
    $defi_suppression = $db->prepare("DELETE FROM defis_journaliers WHERE date != :date");
    $defi_suppression->bindParam(':date', $date_actuelle);
    $defi_suppression->execute();
    $defi_utilisateur_suppression = $db->prepare("DELETE FROM utilisateursdefiquotidien WHERE dateObtention != :date");
    $defi_utilisateur_suppression->bindParam(':date', $date_actuelle);
    $defi_utilisateur_suppression->execute();
    $defis_journaliers = $stmt_select_defis->fetchAll(PDO::FETCH_ASSOC);

    // Récupération de l'ID de l'utilisateur associé à son pseudo
    $stmt_select_id = $db->prepare("SELECT ID_Utilisateur FROM utilisateurs WHERE ID_Utilisateur = :id_utilisateur");
    $stmt_select_id->bindParam(':id_utilisateur', $_SESSION['user_id']);
    $stmt_select_id->execute();
    $id_utilisateur = $stmt_select_id->fetchColumn();

    // Si le formulaire de validation du défi a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['valider_defi'])) {
        $id_defi = $_POST['id_defi'];
        $sql = "SELECT * FROM `utilisateursdefiquotidien` WHERE `ID_Utilisateur` = $id_utilisateur AND `ID_Defi` = $id_defi AND `dateObtention` = '$date_actuelle'";
        $stmt_select_userDefi = $db->prepare($sql);
        $stmt_select_userDefi->execute();
        $defiuser = $stmt_select_userDefi->fetch();
        if (empty($defiuser)) {
            $stmt_update_defi = $db->prepare("INSERT INTO utilisateursdefiquotidien (ID_Utilisateur, ID_Defi, dateObtention) VALUES (:id_utilisateur, :id_defi, :date_obtention) ON DUPLICATE KEY UPDATE dateObtention = VALUES(dateObtention)");
            $stmt_update_defi->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt_update_defi->bindParam(':id_defi', $_POST['id_defi']);
            $stmt_update_defi->bindParam(':date_obtention', $date_actuelle);
            $stmt_update_defi->execute();
            $stmt_update_score = $db->prepare("UPDATE utilisateurs INNER JOIN utilisateursdefiquotidien ON utilisateurs.ID_Utilisateur = utilisateursdefiquotidien.ID_Utilisateur INNER JOIN defiquotidien ON utilisateursdefiquotidien.ID_Defi = defiquotidien.ID_Defi SET utilisateurs.point_Planete = utilisateurs.point_Planete + defiquotidien.point, utilisateurs.exp_Utilisateur = utilisateurs.exp_Utilisateur + defiquotidien.point WHERE utilisateurs.ID_Utilisateur = :id_utilisateur");
            $stmt_update_score->bindParam(':id_utilisateur', $_SESSION['user_id']);
            $stmt_update_score->execute();
            if ($id_defi == 1) {
                $id_succes = 2;
                $id_succes2 = 4;
                $id_succes3 = 5;
            } else if ($id_defi == 2) {
                $id_succes = 8;
                $id_succes2 = 9;
                $id_succes3 = 10;
            } else if ($id_defi == 3) {
                $id_succes = 11;
                $id_succes2 = 12;
                $id_succes3 = 13;
            } else if ($id_defi == 4) {
                $id_succes = 3;
                $id_succes2 = 6;
                $id_succes3 = 7;
            } else {
                $id_succes = 16;
                $id_succes2 = 17;
                $id_succes3 = 18;
            } 
            $stmt_select_succes = $db->prepare("SELECT * FROM utilisateursucces INNER JOIN utilisateurs ON utilisateurs.ID_Utilisateur = utilisateursucces.ID_Utilisateur INNER JOIN succes ON succes.ID_Succes = utilisateursucces.ID_Succes WHERE utilisateursucces.ID_Succes = :id_succes AND utilisateurs.ID_Utilisateur = :id_utilisateur");
            $stmt_select_succes->bindParam(':id_succes', $id_succes);
            $stmt_select_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
            $stmt_select_succes->execute(); 
            $succesuser = $stmt_select_succes->fetch();
            if (empty($succesuser)) {
                echo "<script>console.log('Pas de progression')</script>";
                $stmt_update_defi = $db->prepare("INSERT INTO utilisateursucces (ID_Utilisateur, ID_Succes, progression) VALUES (:id_utilisateur, :id_succes, 1)");
                $stmt_update_defi->bindParam(':id_utilisateur', $_SESSION['user_id']);
                $stmt_update_defi->bindParam(':id_succes', $id_succes);
                $stmt_update_defi->execute();
                $stmt_update_defi2 = $db->prepare("INSERT INTO utilisateursucces (ID_Utilisateur, ID_Succes, progression) VALUES (:id_utilisateur, :id_succes, 1)");
                $stmt_update_defi2->bindParam(':id_utilisateur', $_SESSION['user_id']);
                $stmt_update_defi2->bindParam(':id_succes', $id_succes2);
                $stmt_update_defi2->execute();
                $stmt_update_defi3 = $db->prepare("INSERT INTO utilisateursucces (ID_Utilisateur, ID_Succes, progression) VALUES (:id_utilisateur, :id_succes, 1)");
                $stmt_update_defi3->bindParam(':id_utilisateur', $_SESSION['user_id']);
                $stmt_update_defi3->bindParam(':id_succes', $id_succes3);
                $stmt_update_defi3->execute();
            } else if ($succesuser[4] != "0000-00-00") {
                echo "<script>console.log('Progression 1 fini')</script>";
                $stmt_select_succes2 = $db->prepare("SELECT dateObtention FROM utilisateursucces WHERE ID_Succes = :id_succes2 AND ID_Utilisateur = :id_utilisateur");
                $stmt_select_succes2->bindParam(':id_succes2', $id_succes2);
                $stmt_select_succes2->bindParam(':id_utilisateur', $_SESSION['user_id']);
                $stmt_select_succes2->execute(); 
                $dateObtention2 = $stmt_select_succes2->fetch();
                if ($dateObtention2[0] != "0000-00-00") {
                    echo "<script>console.log('Progression 2 fini')</script>";
                    $stmt_select_succes2 = $db->prepare("SELECT dateObtention FROM utilisateursucces WHERE ID_Succes = :id_succes2 AND ID_Utilisateur = :id_utilisateur");
                    $stmt_select_succes2->bindParam(':id_succes2', $id_succes3);
                    $stmt_select_succes2->bindParam(':id_utilisateur', $_SESSION['user_id']);
                    $stmt_select_succes2->execute(); 
                    $dateObtention2 = $stmt_select_succes2->fetch();
                    if ($dateObtention2[0] != "0000-00-00") {
                        echo "<script>console.log('Progression 3 fini')</script>";
                    } else {
                        echo "<script>console.log('Progression 3 en cours')</script>";
                        $stmt_update_succes = $db->prepare("UPDATE utilisateursucces SET progression = progression + 1 WHERE ID_Utilisateur = :id_utilisateur AND ID_Succes = :id_succes3");
                        $stmt_update_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
                        $stmt_update_succes->bindParam(':id_succes3', $id_succes3);
                        $stmt_update_succes->execute();
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
                            $stmt_update_succes = $db->prepare("UPDATE utilisateursucces SET dateObtention = :dateActuel WHERE ID_Utilisateur = :id_utilisateur AND ID_Succes = :id_succes");
                            $stmt_update_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
                            $stmt_update_succes->bindParam(':id_succes', $id_succes3);
                            $stmt_update_succes->bindParam(':dateActuel', $dateActuel);
                            $stmt_update_succes->execute();
                        }
                    }
                } else {
                    echo "<script>console.log('Progression 2 en cours')</script>";
                    $stmt_update_succes = $db->prepare("UPDATE utilisateursucces SET progression = progression + 1 WHERE ID_Utilisateur = :id_utilisateur AND ID_Succes = :id_succes2 OR ID_Succes = :id_succes3");
                    $stmt_update_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
                    $stmt_update_succes->bindParam(':id_succes2', $id_succes2);
                    $stmt_update_succes->bindParam(':id_succes3', $id_succes3);
                    $stmt_update_succes->execute();
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
                        $stmt_update_succes = $db->prepare("UPDATE utilisateursucces SET dateObtention = :dateActuel WHERE ID_Utilisateur = :id_utilisateur AND ID_Succes = :id_succes");
                        $stmt_update_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
                        $stmt_update_succes->bindParam(':id_succes', $id_succes2);
                        $stmt_update_succes->bindParam(':dateActuel', $dateActuel);
                        $stmt_update_succes->execute();
                    }
                }
            } else {
                echo "<script>console.log('Progression 1 continuer')</script>";
                $stmt_update_succes = $db->prepare("UPDATE utilisateursucces SET progression = progression + 1 WHERE ID_Utilisateur = :id_utilisateur AND ID_Succes = :id_succes OR ID_Succes = :id_succes2 OR ID_Succes = :id_succes3");
                $stmt_update_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
                $stmt_update_succes->bindParam(':id_succes', $id_succes);
                $stmt_update_succes->bindParam(':id_succes2', $id_succes2);
                $stmt_update_succes->bindParam(':id_succes3', $id_succes3);
                $stmt_update_succes->execute();
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
                    echo "<script>console.log('date 1 ajouter')</script>";
                    $dateActuel = date("Y-m-d");
                    $stmt_update_succes = $db->prepare("UPDATE utilisateursucces SET dateObtention = :dateActuel WHERE ID_Utilisateur = :id_utilisateur AND ID_Succes = :id_succes");
                    $stmt_update_succes->bindParam(':id_utilisateur', $_SESSION['user_id']);
                    $stmt_update_succes->bindParam(':id_succes', $id_succes);
                    $stmt_update_succes->bindParam(':dateActuel', $dateActuel);
                    $stmt_update_succes->execute();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Défis</title>
</head>

<body>

    <div id="defi_patern_box">

    <div id="defi_title_box">
    <img src="../img/DEFIS.svg" alt="épingle" id="defi_epingle_img">
    

    <h1 id="defis_h1"><a href="../index.php">Earthly</a></h1>

</div>

<div id="defis_communautaire_box">
<img src="../img/people.svg" alt="people icon" id="defis_communautaire_people">
<h2 id="defis_communautaire_h2">Les défis communautaires</h2>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" id="defis_communautaire_chevron">
  <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
</svg>

</div>
    <?php
    // Si des défis sont sélectionnés pour la journée actuelle
    if (!empty($defis_journaliers)) {
        // Afficher les défis sélectionnés pour la journée
        echo "<div id='defis_challenge_box'>Liste des défis</h2>";
        echo "<h2 id='defis_h2'>Liste des défis</h2>";
        echo "<ul id='defis_ul'>";
        foreach ($defis_journaliers as $defi) {
            echo "<div class='defi'>";
            echo "<strong>", $defi['nom'], "</strong>: ", $defi['desc'];
            // Afficher le bouton pour valider le défi dans un formulaire
            echo "<form method='POST' action='defi.php' id='defi_form'>";
            echo "<input type='hidden' name='id_defi' value='" . $defi['ID_Defi'] . "'>";
            $id_defi = $defi['ID_Defi'];
            $sql = "SELECT * FROM `utilisateursdefiquotidien` WHERE `ID_Utilisateur` = $id_utilisateur AND `ID_Defi` = $id_defi AND `dateObtention` = '$date_actuelle'";
            $stmt_select_userDefi = $db->prepare($sql);
            $stmt_select_userDefi->execute();
            $defiuser = $stmt_select_userDefi->fetch();
            if (!empty($defiuser)) {
                echo "Defi Reussi !";
            } else {
                echo "<button type='submit' name='valider_defi' id='defis_button'>Valider le défi</button>";
            }

            echo "</form>";
            echo "</div>";
        }
        echo "</ul>";
    } else {
        echo "<a href='defi.php'>Rafraîchir la page pour voir les defis</a>";
        $requete_defis = $db->query("SELECT * FROM defiquotidien ORDER BY RAND() LIMIT 3");
        $defis_selectionnes = $requete_defis->fetchAll(PDO::FETCH_ASSOC);

        // Insérer les défis sélectionnés dans la table des défis journaliers
        $stmt_insert_defis = $db->prepare("INSERT INTO defis_journaliers (ID_Defi, date) VALUES (:id_defi, :date)");
        foreach ($defis_selectionnes as $defi) {
            $stmt_insert_defis->bindParam(':id_defi', $defi['ID_Defi']);
            $stmt_insert_defis->bindParam(':date', $date_actuelle);
            $stmt_insert_defis->execute();
        }
    }
    ?>

<a href="success.php">vers les success</a>

</div>
    <?php
        include("../form/templates/footer.php")
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>