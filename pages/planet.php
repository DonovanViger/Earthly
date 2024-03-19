<?php

session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if(!isset($_SESSION['pseudo'])) {
    // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erreur) {
    die("Erreur de connexion à la base de données : ". $erreur->getMessage());
}

// Requête SQL pour récupérer les informations de l'utilisateur
$requete = $db->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo");
$requete->bindParam(':pseudo', $pseudo);
$requete->execute();

// Récupération des résultats de la requête
$utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Earthly | Planète</title>
</head>
<body>

<?php
        if ($utilisateur['point_Planete'] < 1000) {
            $niv = 1;
        } else if ($utilisateur['point_Planete'] < 3000) {
            $niv = 2;
        } else if ($utilisateur['point_Planete'] < 7000) {
            $niv = 3;
        } else if ($utilisateur['point_Planete'] < 15000) {
            $niv = 4;
        } else  {
            $niv = 5;
            ?>
            <div class="sketchfab-embed-wrapper"> <iframe title="lvl5" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share src="https://sketchfab.com/models/da58575a4b5d48a5b39b399e56e023f1/embed?autospin=0.05&autostart=1&dnt=1"> </iframe> </div>
                <?php
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