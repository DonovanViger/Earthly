<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Classement</title>
    <style>
        .avatar {
            width: 75px; /* Ajustez la taille de l'avatar selon vos besoins */
            height: 75px; /* Ajustez la taille de l'avatar selon vos besoins */
            border-radius: 50%; /* Pour créer une image en forme de cercle */
        }
    </style>
</head>
<body>
    
<?php
session_start(); // Démarre la session

try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erreur) {
    die("Erreur de connexion à la base de données : " . $erreur->getMessage());
}

$requeteClassement = $db->prepare("SELECT `pseudo`,`point_Utilisateur`, IFNULL(`pdp`, '../uploads/default.jpg') AS `pdp` FROM `utilisateurs` ORDER BY `point_Utilisateur` DESC LIMIT 10;");
$requeteClassement->execute();
$Classements = $requeteClassement->fetchAll(PDO::FETCH_ASSOC);
$i = 0;
?>


<h1 id="h1_classement"><a href="../index.php">Earthly</a></h1>
<h2 id="h2_classement">Classement</h2>
<table id="table_classement">
    <thead>
        <tr>
            <th scope="col">N°</th>
            <th scope="col">Pseudo</th>
            <th scope="col">Points</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($Classements as $classement) { ?>
            <?php
            $i = $i + 1 
            ?>
            <tr>
                <td>
                    <?php echo $i ?>
                </td>
                <td>
                    <img src="<?php echo $classement['pdp']; ?>" alt="Avatar de <?php echo $classement['pseudo']; ?>" class="avatar">
                </td>
                <td>
                    <?php echo $classement['pseudo']; ?>
                </td>
                <td>
                    <?php echo $classement['point_Utilisateur']; ?>
                </td>

            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
        // Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté

        if (isset($_SESSION['pseudo'])) {
        ?>
        <footer>
        <ul class="footer-nav">
            <li><a href="planet.php">Ma Planète</a></li>
            <li><a href="defi.php">Mes défis journaliers</a></li>
            <li><a href="recyclage.php">Carte des poubelles</a></li>
            <li><a href="compte.php">Mon compte</a></li>
            <li><a href="classement.php">Classement</a></li>
        </ul>
        </footer>
<?php
        }

?>
</body>
</html>