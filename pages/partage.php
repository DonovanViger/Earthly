<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <title>Partage</title>
</head>

<body>
    <?php
    session_start(); // Démarre la session
    try {
        // Connexion à la base de données
        $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        setlocale(LC_TIME, "fr_FR");

        // Récupération des informations de l'utilisateur connecté à partir de la session
        $pseudo = $_SESSION['pseudo'];

        // Requête SQL pour récupérer les informations de l'utilisateur
        $requete = $db->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo");
        $requete->bindParam(':pseudo', $pseudo);
        $requete->execute();

        // Récupération des résultats de la requête
        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur a une image de profil
        $profileImage = $utilisateur['pdp'] ? $utilisateur['pdp'] : '../uploads/default.jpg';
    } catch (PDOException $erreur) {
        // En cas d'erreur de connexion à la base de données
        die("Erreur de connexion à la base de données : " . $erreur->getMessage());
    }

    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION['pseudo'])) {
        // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
        header("Location: connexion.php");
        exit();
    }

    if (isset($_SESSION['pseudo'])) {
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
    <h1 id="h1_compte"><a href="../index.php">Earthly</a></h1>

    
    <section id="profil">


        <h2 id="h2_compte"><?php echo $utilisateur['pseudo']; ?></h2>
        <div id="compte_bar"></div>
        <!-- Affichage de l'image de profil -->
        <div id="image_compte">
            <img src="<?php echo $profileImage; ?>" alt="Image de profil" class="profile-image">
        </div>
        <div id="texte_compte">
            <ul>
                <li>Pseudo : <?php echo $utilisateur['pseudo']; ?></li>
                <li>Points : <?php echo $utilisateur['point_Utilisateur']; ?></li>
                <?php if (!empty($utilisateur['ID_parrain'])) : ?>
                <li>Parrain : <?php echo $utilisateur['ID_parrain']; ?></li>
                <?php endif; ?>
                <li>Date de dernière connexion : <?php echo date("j F Y", strtotime($utilisateur['dateConnexion'])); ?>
                </li>
                <li>Niveau d'expérience sur la planète : <?php echo $utilisateur['expPlaneteUtilisateur']; ?></li>
            </ul>
        </div>

            

        if (isset($_SESSION['pseudo'])) {
        ?>
        <ul class="footer-nav">
        <li><a href="recyclage.php">Carte des poubelles</a></li>
        <li><a href="planet.php">Ma Planète</a></li>
        <li><a href="defi.php">Mes défis journaliers</a></li>
        <li><a href="classement.php">Classement</a></li>
        <li><a href="compte.php">Mon compte</a></li>
        </ul>
<?php
        }

?>

</body>

</html>