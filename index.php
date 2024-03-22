<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="pages/style.css" />
    <title>Earthly</title>
    <style>
        footer {
            margin-left: 0; /* Correction ici */
        }
    </style>
</head>

<body>

    <?php
    session_start(); // Démarre la session (à placer au début de chaque fichier PHP où vous utilisez des sessions)

    // Vérifie si l'utilisateur est connecté
    if (isset($_SESSION['pseudo'])) {
        $pseudo = $_SESSION['pseudo'];
        echo "Bienvenue, $pseudo!";
        // Affiche le reste de votre contenu pour les utilisateurs connectés
    }
    ?>


    <h1><a href="#">Earthly</a></h1>
    <h2>Care for the world</h2>
    <h3>C'est quoi l'application Earthly ?</h3>

    <p>Earthly est une application de sensibilisation et d’information ludique qui pousse ses utilisateurs et les
        personnes se questionnant sur l’écologie à effectuer des actions au quotidien dans l’objectif d’améliorer leur
        impact sur l’environnement.
        Elle sensibilise en mettant en avant des poubelles intelligentes destinées au recyclage, qui seront installées
        dans les rues des grandes villes. Une carte dynamique sera mise à disposition afin d’indiquer les différents
        lieux liés à l’écologies autour de l’utilisateur tel que les bennes de recyclage publiques, des jardins
        participatifs, des bornes de recharge électriques et autres...
    </p> <!-- Correction ici -->

    <h3>Comment s'amuser tout en étant écoresponsable ?</h3>

    <p>Les poubelles intelligentes et les défis écologiques proposés à l’utilisateur vous permettront de gagner des
        points d’expérience ainsi que des badges/succès marquant des actions. Une des pages de l’application est dédiée
        à l’entretient d’un petit monde en 3D, les points d’expérience de l’utilisateur et ses actions, influeront sur
        l’état et l’apparence de ce monde (Commençant pollué et en mauvais état, pour parvenir à une petite planète
        verte et en bonne santé). Ce jeu au sein de l’application engagera l’utilisateur et vous donnera un objectif
        visuel et concret. Ce monde dynamique réagira au actions de l’utilisateur pouvant même se dégrader en cas
        d’inactivité, poussant l’utilisateur à revenir sur l’application.</p>

    <ul>
        <?php
        // Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté
        if (!isset($_SESSION['pseudo'])) {
        ?>
            <li><a href="pages/connexion.php">Se connecter</a></li>
            <li><a href="pages/inscription.php">Créer un compte</a></li>
        <?php
        }
        ?>
    </ul> <!-- Correction ici -->

    <?php
    if (isset($_SESSION['pseudo'])) {
    ?>
<footer>
    <div class="nav">
        <div class="nav-slot">
            <a href="pages/recyclage.php" class="nav-link" id="recyclage">
                <img src="img/nav bar/Scanner noir.png" class="footer-image" data-image="2.png">
                <span class="image-text">Recyclage</span>
            </a>
        </div>
        <div class="nav-slot round-top-left">
            <a href="pages/defi.php" class="nav-link" id="defi">
                <img src="img/nav bar/Defis noir.png" class="footer-image" data-image="1.png">
                <span class="image-text">Défis</span>
            </a>
        </div>
        <div class="nav-slot">
            <a href="pages/planet.php" class="nav-link" id="planet">
                <img src="img/nav bar/home_noir.png" class="footer-image planet-icon" data-image="3.png">
            </a>
        </div>
        <div class="nav-slot">
            <a href="pages/classement.php" class="nav-link" id="classement">
                <img src="img/nav bar/Classement noir.png" class="footer-image" data-image="4.png">
                <span class="image-text">Classement</span>
            </a>
        </div>
        <div class="nav-slot round-top-right">
            <a href="pages/compte.php" class="nav-link" id="compte">
                <img src="img/nav bar/Profil noir.png" class="footer-image" data-image="5.png">
                <span class="image-text">Compte</span>
            </a>
        </div>
    </div>
</footer>
        <?php
        $pseudo = $_SESSION['pseudo'];

        $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        setlocale(LC_TIME, "fr_FR");

        $dateConnexion = date("Y-m-d");

        $query = $db->prepare("UPDATE utilisateurs SET dateConnexion = :dateConnexion WHERE pseudo = :pseudo");

        // Liez les paramètres et exécutez la requête
        $query->bindParam(':dateConnexion', $dateConnexion, PDO::PARAM_STR);
        $query->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $query->execute();
    }

    ?>
</body>

</html>
