<?php

session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['pseudo'])) {
    // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erreur) {
    die("Erreur de connexion à la base de données : " . $erreur->getMessage());
}

// Requête SQL pour récupérer les informations de l'utilisateur
$requete = $db->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo");
$requete->bindParam(':pseudo', $_SESSION['pseudo']);
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
    <style>
        .loader {
        background-color :#000000 ;
        width: 100%;
        height: 100%;
        animation: fadeOut 0.5s 4s forwards;
        margin: auto;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        opacity: 1;
        z-index: 1;
        display: flex;
        justify-content: center;
        /* align-content: center; */
        align-items: center;
        }
        .loader video{
            width: 100%
        }


       @keyframes fadeOut {
            0% { opacity: 1; }
            100% { opacity: 0; display: none; }
        }
    </style>
</head>
<body>
<div class="loader">
    <video autoplay loop muted>
        <source src="..\pack-icon\chargement\chargement.mp4" type="video/mp4">
        <!-- Fallback si le navigateur ne prend pas en charge le format MP4 -->
        Votre navigateur ne prend pas en charge la lecture de vidéos au format MP4.
    </video>
</div>

<?php
if ($utilisateur['point_Planete'] < 1000) {
    ?>
                <div class="sketchfab-embed-wrapper"> <iframe title="lvl1" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share src="https://sketchfab.com/models/2af6d5ca9b3b42d9ae3019f7d8791e6c/embed?autospin=0.05&autostart=1"> </iframe> </div>
                <?php
                $niv = 1;
} else if ($utilisateur['point_Planete'] < 3000) {
    ?>
                    <div class="sketchfab-embed-wrapper"> <iframe title="lvl2" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share src="https://sketchfab.com/models/caee053f40084feda87bc36ec68954a9/embed?autospin=0.05&autostart=1&ui_hint=0"> </iframe> </div>
                    <?php
                    $niv = 2;
} else if ($utilisateur['point_Planete'] < 7000) {
    ?>
                        <div class="sketchfab-embed-wrapper"> <iframe title="lvl3" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share src="https://sketchfab.com/models/ccdded613db848cb82ec33e1c1d6661a/embed?autospin=0.05&autostart=1&ui_hint=0"> </iframe> </div>
                    <?php
                    $niv = 3;
} else if ($utilisateur['point_Planete'] < 15000) {
    ?>
                            <div class="sketchfab-embed-wrapper"> <iframe title="lvl4" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share src="https://sketchfab.com/models/121a52bc2afc464382365e2c0080a5b6/embed?autospin=0.05&autostart=1&ui_hint=0"> </iframe> </div>
                    <?php
                    $niv = 4;
} else {
    $niv = 5;
    ?>
                            <div class="sketchfab-embed-wrapper"> <iframe title="lvl5" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking execution-while-out-of-viewport execution-while-not-rendered web-share src="https://sketchfab.com/models/da58575a4b5d48a5b39b399e56e023f1/embed?autospin=0.05&autostart=1&dnt=1"> </iframe> </div>
                    <?php
}
?>


<div id="planet_overall">

<?php
// Les points de l'utilisateur (remplacez cela par vos données)
$pointsUtilisateur = $utilisateur['point_Planete'];

// Calcul du niveau en fonction des points
if ($pointsUtilisateur < 1000) {
    $niveauActuel = 1;
    $pointsNiveauSuivant = 1000;
} elseif ($pointsUtilisateur < 3000) {
    $niveauActuel = 2;
    $pointsNiveauSuivant = 3000;
} elseif ($pointsUtilisateur < 7000) {
    $niveauActuel = 3;
    $pointsNiveauSuivant = 7000;
} elseif ($pointsUtilisateur < 15000) {
    $niveauActuel = 4;
    $pointsNiveauSuivant = 15000;
} else {
    $niveauActuel = 5;
    $pointsNiveauSuivant = null; // Pas de niveau suivant car c'est le dernier niveau
}

$progression = ($pointsUtilisateur / $pointsNiveauSuivant) * 100;
?>
<div id="planet_box_logo">
<img src="../uploads/Logo-earthly-text.svg" alt="logo_earthly" id="planet_logo">
</div>
<div id="planet_annotation">
    <?php
    if ($utilisateur['point_Planete'] < 1000) {
        echo "<h2 id='planet_h2_annotation'>NIVEAU 1</h2>";
        echo "<h3 id='planet_h3_annotation'>Plus que " . "<strong id='planet_points_vert'>" . (1000 - $utilisateur['point_Planete']) . "</strong>" . " points d'expérience avant le niveau 2 !</h3>";
        echo "<h3 id='planet_h3_annotation_ex'>" . $utilisateur['point_Planete'] . "xp</h3>";
        echo "<h3 id='planet_h3_annotation_lv'>1000</h3>";
    } else if ($utilisateur['point_Planete'] < 3000) {
        echo "<h2 id='planet_h2_annotation'>NIVEAU 2</h2>";
        echo "<h3 id='planet_h3_annotation'>Plus que " . "<strong id='planet_points_vert'>" . (3000 - $utilisateur['point_Planete']) . "</strong>" . " points d'expérience avant le niveau 3 !</h3>";
        echo "<h3 id='planet_h3_annotation_ex'>" . $utilisateur['point_Planete'] . "xp</h3>";
        echo "<h3 id='planet_h3_annotation_lv'>3000</h3>";
    } else if ($utilisateur['point_Planete'] < 7000) {
        echo "<h2 id='planet_h2_annotation'>NIVEAU 3</h2>";
        echo "<h3 id='planet_h3_annotation'>Plus que " . "<strong id='planet_points_vert'>" . (7000 - $utilisateur['point_Planete']) . "</strong>" . " points d'expérience avant le niveau 4 !</h3>";
        echo "<h3 id='planet_h3_annotation_ex'>" . $utilisateur['point_Planete'] . "xp</h3>";
        echo "<h3 id='planet_h3_annotation_lv'>7000</h3>";
    } else if ($utilisateur['point_Planete'] < 15000) {
        echo "<h2 id='planet_h2_annotation'>NIVEAU 4</h2>";
        echo "<h3 id='planet_h3_annotation'>Plus que " . "<strong id='planet_points_vert'>" . (15000 - $utilisateur['point_Planete']) . "</strong>" . " points d'expérience avant le niveau 5 !</h3>";
        echo "<h3 id='planet_h3_annotation_ex'>" . $utilisateur['point_Planete'] . "xp</h3>";
        echo "<h3 id='planet_h3_annotation_lv'>15000</h3>";
    } else {
        echo "<h2 id='planet_h2_annotation'>NIVEAU 5</h2>";
        echo "<h3 id='planet_h3_annotation'>Bravo, votre planète est au niveau maximal avec un total de " . "<strong id='planet_points_vert'>" . (1000 - $utilisateur['point_Planete']) . "</strong>" . " points d'expérience !</h3>";
    }
    ?>
                <br> 
        <div class="progress">
    <div class="progress-bar" role="progressbar" style="width: <?= $progression ?>%;" aria-valuenow="<?= $progression ?>" aria-valuemin="0" aria-valuemax="100"></div>
  </div>
    </div>
</div>






<?php
include ("../form/templates/footer.php")
    ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>
</html>