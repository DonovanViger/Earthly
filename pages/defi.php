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
    <title>Défis</title>
</head>

<body>

    <h1><a href="../index.php">Earthly</a></h1>

    <?php

    try {
        // Connexion à la base de données
        $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $date_actuelle = date('Y-m-d');
        

        // Vérification si des défis sont déjà sélectionnés pour la journée actuelle
        $stmt_select_defis = $db->prepare(" SELECT defis_journaliers.date, defiquotidien.nom, defiquotidien.desc FROM defis_journaliers INNER JOIN defiquotidien ON defis_journaliers.ID_Defi = defiquotidien.ID_Defi WHERE defis_journaliers.date = :date
    ");
        $stmt_select_defis->bindParam(':date', $date_actuelle);
        $stmt_select_defis->execute();
        $defis_journaliers = $stmt_select_defis->fetchAll(PDO::FETCH_ASSOC);

        // Affichage des défis sélectionnés pour la journée
        echo "<h2>Liste des défis</h2>";
        echo "<ul>";
        foreach ($defis_journaliers as $defi) {
            echo "<div class='defi'>";
            echo "<strong>", $defi['nom'], "</strong>: ", $defi['desc'];
            echo "<button>Valider le défi</button>";
            echo "</div>";
        }
        echo "</ul>";
    } catch (PDOException $erreur) {
        // En cas d'erreur de connexion à la base de données
        die("Erreur de connexion à la base de données : " . $erreur->getMessage());
    }

// Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté

if (isset($_SESSION['pseudo'])) {
?>
    <li><a href="planet.php">Ma Planète</a></li>
    <li><a href="defi.php">Mes défis journaliers</a></li>
    <li><a href="recyclage.php">Carte des poubelles</a></li>
    <li><a href="compte.php">Mon compte</a></li>
    <li><a href="classement.php">Classement</a></li>
</ul>
<?php
}

    ?>

</body>

</html>