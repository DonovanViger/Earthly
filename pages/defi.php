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
            $stmt_update_score = $db->prepare("UPDATE utilisateurs INNER JOIN utilisateursdefiquotidien ON utilisateurs.ID_Utilisateur = utilisateursdefiquotidien.ID_Utilisateur INNER JOIN defiquotidien ON utilisateursdefiquotidien.ID_Defi = defiquotidien.ID_Defi SET utilisateurs.point_Utilisateur = utilisateurs.point_Utilisateur + defiquotidien.point; WHERE `pseudo` = :pseudo;");
            $stmt_update_score->bindParam(':pseudo', $_SESSION['pseudo']);
            $stmt_update_score->execute();

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

</body>

</html>