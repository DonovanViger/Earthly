<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../pages/style.css" />
    <title>Earthly | Supprimer le compte</title>
</head>

<body>
    <?php
try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            $requeteSuppressionSucces = $db->prepare("DELETE FROM utilisateursucces WHERE ID_Utilisateur = :id_user");
            $requeteSuppressionSucces->bindParam(':id_user', $user_id);
            $requeteSuppressionSucces->execute();

            $requeteSuppressionDefiQuotidien = $db->prepare("DELETE FROM utilisateursdefiquotidien WHERE ID_Utilisateur = :id_user");
            $requeteSuppressionDefiQuotidien->bindParam(':id_user', $user_id);
            $requeteSuppressionDefiQuotidien->execute();

            $requete = $db->prepare("SELECT pdp FROM utilisateurs WHERE ID_Utilisateur = :id");
            $requete->bindParam(':id', $user_id);
            $requete->execute();
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);

            if ($resultat) {
                $chemin_photo_profil = "../uploads/" . $resultat['pdp'];
            
                if (file_exists($chemin_photo_profil)) {
                    if (unlink($chemin_photo_profil)) {
                        echo "";
                    } else {
                        echo "Erreur lors de la suppression de la photo de profil.";
                    }
                } else {
                    echo "La photo de profil n'existe pas.";
                }
            } else {
                echo "Échec de la récupération de la photo de profil depuis la base de données.";
            }

            $requeteSuppression = $db->prepare("DELETE FROM utilisateurs WHERE ID_Utilisateur = :user_id");
            $requeteSuppression->bindParam(':user_id', $user_id);
            $requeteSuppression->execute();

            echo "<div class='erreur_connexion_box'>";
            echo "<p class='erreur_connexion_para'>Compte supprimé avec succès</p>";
            echo "<button class='erreur_button_form'><a href='../pages/inscription.php'>Retour à la page d'inscription</a>";
            echo "</div>";
        } else {
            echo "<div class='erreur_connexion_box'>";
            echo "<p class='erreur_connexion_para'>Erreur : ID utilisateur non défini.</p>";
            echo "<button class='erreur_button_form'><a href='../pages/connexion.php'>Retour à la page de connexion</a>";
            echo "</div>";
        }
    }
} catch (PDOException $erreur) {
    die("Erreur de connexion à la base de données : " . $erreur->getMessage());
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
</body>

</html>