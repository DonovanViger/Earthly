<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/" href="../img2/Fichier 27.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../pages/style.css" />
    <title>Earthly | Erreur de connexion</title>
</head>
<body>
    
</body>
</html>

<?php
session_start();

try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pseudo = $_POST['pseudo'];
    $mdp = hash('sha256', $_POST['mdp']);

    $requete = $db->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo AND mdp = :mdp");
    $requete->bindParam(':pseudo', $pseudo);
    $requete->bindParam(':mdp', $mdp);
    $requete->execute();

    $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);
    if ($utilisateur) {
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['mail'] = $utilisateur['mail']; // Ajoute l'adresse e-mail à la variable de session
        $_SESSION['user_id'] = $utilisateur['ID_Utilisateur'];

        $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        setlocale(LC_TIME, "fr_FR");

        $dateConnexion = date("Y-m-d");
        $select_dateconnexion = $db->prepare("SELECT TIMESTAMPDIFF(DAY, dateConnexion, CURDATE()) AS jours_ecoules FROM utilisateurs WHERE `pseudo` = :pseudo");
        $select_dateconnexion->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $select_dateconnexion->execute();
        $pointEnMoins = $select_dateconnexion->fetch(PDO::FETCH_ASSOC);


        if ($pointEnMoins) {
            $jours_ecoules = $pointEnMoins['jours_ecoules'];
            if ($jours_ecoules >= 1) {
                $pointEnMoins = $jours_ecoules - 1;
                $pointEnMoins = $pointEnMoins * -200;
            } else {
                $pointEnMoins = 0;
            }
        } else {
            $pointEnMoins = 0;
        }


        $query = $db->prepare("UPDATE utilisateurs SET dateConnexion = :dateConnexion, point_Planete = point_Planete + :pointEnMoins WHERE pseudo = :pseudo");
        $query->bindParam(':dateConnexion', $dateConnexion, PDO::PARAM_STR);
        $query->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $query->bindParam(':pointEnMoins', $pointEnMoins, PDO::PARAM_STR);
        $query->execute();


        $select_point = $db->prepare("SELECT point_Planete FROM utilisateurs WHERE pseudo = :pseudo");
        $select_point->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $select_point->execute();
        $pointActuelle = $select_point->fetch(PDO::FETCH_ASSOC);

        $pointActuelle = $pointActuelle['point_Planete'];

        if ($pointActuelle < 0) {
            $pointActuelle = 0;
            $update_pointNeg = $db->prepare("UPDATE utilisateurs SET point_Planete = :pointActuelle WHERE pseudo = :pseudo");
            $update_pointNeg->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
            $update_pointNeg->bindParam(':pointActuelle', $pointActuelle, PDO::PARAM_STR);
            $update_pointNeg->execute();
        }

        $select_idutilisateur = $db->prepare("SELECT `ID_Utilisateur` FROM `utilisateurs` WHERE pseudo = :pseudo;");
        $select_idutilisateur->bindParam(':pseudo', $pseudo,PDO::PARAM_STR);
        $select_idutilisateur->execute();
        $id_utilisateur_row = $select_idutilisateur->fetch(PDO::FETCH_ASSOC);
        $id_utilisateur = $id_utilisateur_row['ID_Utilisateur'];
        
        $date_actuelle = date('Y-m-d');
        
        $select_dateDepuisCreation = $db->prepare("SELECT TIMESTAMPDIFF(DAY, dateCreationCompte, CURDATE()) AS jours_ecoules FROM utilisateurs WHERE `pseudo` = :pseudo");
        $select_dateDepuisCreation->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $select_dateDepuisCreation->execute();
        $jourPassee = $select_dateDepuisCreation->fetch(PDO::FETCH_ASSOC);
        
        $select_succesmois = $db->prepare("SELECT * FROM `utilisateursucces` WHERE `ID_Utilisateur` = :IDutilisateur AND `ID_Succes` = 14");
        $select_succesmois->bindParam(':IDutilisateur', $id_utilisateur, PDO::PARAM_STR);
        $select_succesmois->execute();
        $avoirbadgemois = $select_succesmois->fetch(PDO::FETCH_ASSOC);
        
        $select_succesannee = $db->prepare("SELECT * FROM `utilisateursucces` WHERE `ID_Utilisateur` = :IDutilisateur AND `ID_Succes` = 15");
        $select_succesannee->bindParam(':IDutilisateur', $id_utilisateur, PDO::PARAM_STR);
        $select_succesannee->execute();
        $avoirbadgeannee = $select_succesannee->fetch(PDO::FETCH_ASSOC);
        
        if (empty($avoirbadgemois)) {
            if ($jourPassee['jours_ecoules'] >= 30) {
                $insert_badgemois = $db->prepare("INSERT INTO `utilisateursucces`(`ID_Utilisateur`, `ID_Succes`, `progression`, `dateObtention`) VALUES (:id_utilisateur, 14, 1, :datejour)");
                $insert_badgemois->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
                $insert_badgemois->bindParam(':datejour', $date_actuelle, PDO::PARAM_STR);
                $insert_badgemois->execute();
            }
        }
        
        if (empty($avoirbadgeannee)) {
            if ($jourPassee['jours_ecoules'] >= 365) {
                $insert_badgeannee = $db->prepare("INSERT INTO `utilisateursucces`(`ID_Utilisateur`, `ID_Succes`, `progression`, `dateObtention`) VALUES (:id_utilisateur, 15, 1, :datejour)");
                $insert_badgeannee->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
                $insert_badgeannee->bindParam(':datejour', $date_actuelle, PDO::PARAM_STR);
                $insert_badgeannee->execute();
            }
        }

    $select_defis = $db->prepare("SELECT defis_journaliers.date, defiquotidien.nom, defiquotidien.desc FROM defis_journaliers INNER JOIN defiquotidien ON defis_journaliers.ID_Defi = defiquotidien.ID_Defi WHERE defis_journaliers.date = :date");
    $select_defis->bindParam(':date', $date_actuelle);
    $select_defis->execute();
    $defis_journaliers = $select_defis->fetchAll(PDO::FETCH_ASSOC);
    if (!empty ($defis_journaliers)) {
    } else {
        echo "<a href='defi.php'>Rafraîchir la page pour voir les defis</a>";
        $requete_defis = $db->query("SELECT * FROM defiquotidien ORDER BY RAND() LIMIT 3");
        $defis_selectionnes = $requete_defis->fetchAll(PDO::FETCH_ASSOC);

        $insert_defis = $db->prepare("INSERT INTO defis_journaliers (ID_Defi, date) VALUES (:id_defi, :date)");
        foreach ($defis_selectionnes as $defi) {
            $insert_defis->bindParam(':id_defi', $defi['ID_Defi']);
            $insert_defis->bindParam(':date', $date_actuelle);
            $insert_defis->execute();
        }
    }

        header("Location: ../pages/compte.php");
        exit();
    } else {
        echo "<div id='erreur_connexion_box'>";
        echo "<p id='erreur_connexion_para'>Identifiant ou mot de passe incorrect</p>";
        echo "<button id='erreur_button_form'><a href='../pages/connexion.php'>Retour à la page de connexion</a>";
        echo "</div>";
    }
    
} catch (PDOException $erreur) {
    die ("Erreur de connexion à la base de données : " . $erreur->getMessage());
}
?>