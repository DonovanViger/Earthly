<?php
session_start(); 

if (!isset($_SESSION['pseudo'])) {
    header("Location: connexion.php");
    exit();
}

try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erreur) {
    die("Erreur de connexion à la base de données : " . $erreur->getMessage());
}

$requete = $db->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo");
$requete->bindParam(':pseudo', $_SESSION['pseudo']);
$requete->execute();

$utilisateur = $requete->fetch(PDO::FETCH_ASSOC);
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
    <title>Earthly | Planète</title>
    <style>
    .loader {
        background-color: #000000;
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
        align-items: center;
    }

    .loader video {
        width: 100%;
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
        }

        100% {
            opacity: 0;
            display: none;
        }
    }
    </style>
</head>

<body>
    <div class="loader">
        <video autoplay loop muted>
            <source src="../pack-icon/chargement/chargement.mp4" type="video/mp4">
            Votre navigateur ne prend pas en charge la lecture de vidéos au format MP4.
        </video>
    </div>

    <?php
$niv = 0;
if ($utilisateur['point_Planete'] < 1000) {
    $niv = 1;
} elseif ($utilisateur['point_Planete'] < 3000) {
    $niv = 2;
} elseif ($utilisateur['point_Planete'] < 7000) {
    $niv = 3;
} elseif ($utilisateur['point_Planete'] < 15000) {
    $niv = 4;
} else {
    $niv = 5;
}
?>

    <div class="sketchfab-embed-wrapper">
        <iframe title="lvl<?= $niv ?>" frameborder="0" allowfullscreen mozallowfullscreen="true"
            webkitallowfullscreen="true" allow="autoplay; fullscreen; xr-spatial-tracking" xr-spatial-tracking
            execution-while-out-of-viewport execution-while-not-rendered web-share src="https://sketchfab.com/models/<?= $niv == 5 ? 'da58575a4b5d48a5b39b399e56e023f1' : match($niv) {
        1 => '2af6d5ca9b3b42d9ae3019f7d8791e6c',
        2 => 'caee053f40084feda87bc36ec68954a9',
        3 => 'ccdded613db848cb82ec33e1c1d6661a',
        4 => '121a52bc2afc464382365e2c0080a5b6',
        default => ''
    } ?>/embed?autospin=0.05&autostart=1<?= $niv != 5 ? '&ui_hint=0' : '' ?>"></iframe>
    </div>

    <div id="planet_overall">
        <?php
    $pointsUtilisateur = $utilisateur['point_Planete'];

    $niveauActuel = $niv;
    $pointsNiveauSuivant = match($niv) {
        1 => 1000,
        2 => 3000,
        3 => 7000,
        4 => 15000,
        default => null
    };

    if ($pointsNiveauSuivant !== null) {
        $pointsUtilisateur -= match($niv) {
            1 => 0,
            2 => 1000,
            3 => 3000,
            4 => 7000,
            default => 15000
        };
    }

    $progression = ($pointsUtilisateur / $pointsNiveauSuivant) * 100;
    ?>
        <div id="planet_box_logo">
            <img src="../uploads/Logo-earthly-text.svg" alt="logo_earthly" id="planet_logo">
        </div>
        <div id="planet_annotation">
            <h2 id="planet_h2_annotation">NIVEAU <?= $niv ?></h2>
            <?php if ($pointsNiveauSuivant !== null) { ?>
            <h3 id="planet_h3_annotation">Plus que <strong
                    id="planet_points_vert"><?= $pointsNiveauSuivant - $pointsUtilisateur ?></strong> points
                d'expérience avant le niveau <?= $niv + 1 ?> !</h3>
            <?php } else { ?>
            <h3 id="planet_h3_annotation">Bravo, votre planète est au niveau maximal avec un total de <strong
                    id="planet_points_vert"><?= $utilisateur['point_Planete'] ?></strong> points d'expérience !</h3>
            <?php } ?>
            <h3 id="planet_h3_annotation_ex"><?= $pointsUtilisateur ?>xp</h3>
            <?php if ($pointsNiveauSuivant !== null) { ?>
            <h3 id="planet_h3_annotation_lv"><?= $pointsNiveauSuivant ?></h3>

            <?php } ?>
            <br>
            <div class="progress">
    <div class="progress-bar" role="progressbar" style="width: <?= $progression ?>%;" aria-valuenow="<?= $progression ?>" aria-valuemin="0" aria-valuemax="100"></div>
  </div>
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