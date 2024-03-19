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
    $stmt_select_id = $db->prepare("SELECT ID_Utilisateur FROM utilisateurs WHERE pseudo = :pseudo");
    $stmt_select_id->bindParam(':pseudo', $_SESSION['pseudo']);
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
            $stmt_update_score = $db->prepare("UPDATE utilisateurs INNER JOIN utilisateursdefiquotidien ON utilisateurs.ID_Utilisateur = utilisateursdefiquotidien.ID_Utilisateur INNER JOIN defiquotidien ON utilisateursdefiquotidien.ID_Defi = defiquotidien.ID_Defi SET utilisateurs.point_Planete = utilisateurs.point_Planete + defiquotidien.point, utilisateurs.exp_Utilisateur = utilisateurs.exp_Utilisateur + defiquotidien.point WHERE utilisateurs.pseudo = :pseudo");
            $stmt_update_score->bindParam(':pseudo', $_SESSION['pseudo']);
            $stmt_update_score->execute();
            if ($id_defi == 1) {
                $id_succes = 2;
            } else if ($id_defi == 2) {
                $id_succes = 8;
            } else if ($id_defi == 3) {
                $id_succes = 11;
            } else if ($id_defi == 4) {
                $id_succes = 3;
            } else {
                $id_succes = 16;
            } 
            $stmt_update_succes = $db->prepare("SELECT ID_UtilisateurSucces FROM utilisateursucces INNER JOIN utilisateurs ON utilisateurs.ID_Utilisateur = utilisateursucces.ID_Utilisateur INNER JOIN succes ON succes.ID_Succes = utilisateursucces.ID_Succes WHERE utilisateursucces.ID_Succes = :id_succes");
            $stmt_update_succes->bindParam(':id_succes', $id_succes);
            $stmt_update_succes->execute(); 
            $succesuser = $stmt_update_succes->fetch();
            if (empty($succesuser)) {
                echo "<script>console.log('Pas de progression')</script>";
            } else {
                echo "<script>console.log('Progression')</script>";
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

    <h1 id="defis_h1"><a href="../index.php">Earthly</a></h1>

    <?php
    // Si des défis sont sélectionnés pour la journée actuelle
    if (!empty($defis_journaliers)) {
        // Afficher les défis sélectionnés pour la journée
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

    <?php
        include("../form/templates/footer.php")
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>