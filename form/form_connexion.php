<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../pages/style.css" />
    <title>Earthly | Erreur de connexion</title>
</head>
<body>
    
</body>
</html>

<?php
session_start(); // Démarre la session (à placer au début de chaque fichier PHP où vous utilisez des sessions)

try {
    // Connexion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des données du formulaire
    $pseudo = $_POST['pseudo'];
    $mdp = hash('sha256', $_POST['mdp']);

    // Requête SQL pour vérifier les informations de connexion
    $requete = $db->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo AND mdp = :mdp");
    $requete->bindParam(':pseudo', $pseudo);
    $requete->bindParam(':mdp', $mdp);
    $requete->execute();

    // Vérification des résultats de la requête
    $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);
    if ($utilisateur) {
        // Crée une variable de session pour l'utilisateur connecté
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['mail'] = $utilisateur['mail']; // Ajoute l'adresse e-mail à la variable de session
        $_SESSION['user_id'] = $utilisateur['ID_Utilisateur'];

        $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        setlocale(LC_TIME, "fr_FR");

        $dateConnexion = date("Y-m-d");
        $stmt_select_dateconnexion = $db->prepare("SELECT TIMESTAMPDIFF(DAY, dateConnexion, CURDATE()) AS jours_ecoules FROM utilisateurs WHERE `pseudo` = :pseudo");
        $stmt_select_dateconnexion->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $stmt_select_dateconnexion->execute();
        $pointEnMoins = $stmt_select_dateconnexion->fetch(PDO::FETCH_ASSOC);


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


        $stmt_select_point = $db->prepare("SELECT point_Planete FROM utilisateurs WHERE pseudo = :pseudo");
        $stmt_select_point->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $stmt_select_point->execute();
        $pointActuelle = $stmt_select_point->fetch(PDO::FETCH_ASSOC);

        // Assurez-vous de récupérer la valeur de point_Planete à partir du tableau
        $pointActuelle = $pointActuelle['point_Planete'];

        if ($pointActuelle < 0) {
            $pointActuelle = 0;
            $stmt_update_pointNeg = $db->prepare("UPDATE utilisateurs SET point_Planete = :pointActuelle WHERE pseudo = :pseudo");
            $stmt_update_pointNeg->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
            $stmt_update_pointNeg->bindParam(':pointActuelle', $pointActuelle, PDO::PARAM_STR);
            $stmt_update_pointNeg->execute();
        }

        header("Location: ../pages/compte.php"); // Redirige l'utilisateur vers la page d'accueil
        exit();
    } else {
        echo "<div id='erreur_connexion_box'>";
        echo "<p id='erreur_connexion_para'>Identifiant ou mot de passe incorrect</p>";
        echo "<button id='erreur_button_form'><a href='http://localhost/Earthly/Earthly/pages/connexion.php'>Retour à la page de connexion</a>";
        echo "</div>";
        // Redirection vers la page de connexion avec un message d'erreur
    }
    $date_actuelle = date('Y-m-d');

    // Vérification si des défis sont sélectionnés pour la journée actuelle
    $stmt_select_defis = $db->prepare("SELECT defis_journaliers.date, defiquotidien.nom, defiquotidien.desc FROM defis_journaliers INNER JOIN defiquotidien ON defis_journaliers.ID_Defi = defiquotidien.ID_Defi WHERE defis_journaliers.date = :date");
    $stmt_select_defis->bindParam(':date', $date_actuelle);
    $stmt_select_defis->execute();
    $defis_journaliers = $stmt_select_defis->fetchAll(PDO::FETCH_ASSOC);
    // Si la date du jour correspond à la colonne date de la table defis_journaliers
    if (!empty ($defis_journaliers)) {
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
} catch (PDOException $erreur) {
    // En cas d'erreur de connexion à la base de données
    die ("Erreur de connexion à la base de données : " . $erreur->getMessage());
}
?>