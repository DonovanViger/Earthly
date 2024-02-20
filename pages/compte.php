<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if(!isset($_SESSION['pseudo'])) {
    // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

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
} catch (PDOException $erreur) {
    // En cas d'erreur de connexion à la base de données
    die("Erreur de connexion à la base de données : ". $erreur->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>
</head>
<body>
    <h1>Mon compte</h1>
    <h2><?php echo $utilisateur['pseudo']; ?></h2>
    <p>Vos informations :</p>
    <ul>
        <li>Pseudo : <?php echo $utilisateur['pseudo']; ?></li>
        <li>Email : <?php echo $utilisateur['mail']; ?></li>
        <li>Date de création du compte : <?php echo date("j F Y", strtotime($utilisateur['dateCreationCompte'])); ?></li>
        <li>Points : <?php echo $utilisateur['point_Utilisateur']; ?></li>
        <?php if (!empty($utilisateur['ID_parrain'])) : ?>
            <li>Parrain : <?php echo $utilisateur['ID_parrain']; ?></li>
        <?php endif; ?>
        <li>Date de dernière connexion : <?php echo date("j F Y", strtotime($utilisateur['dateConnexion'])); ?></li>
        <li>Niveau d'expérience sur la planète : <?php echo $utilisateur['expPlaneteUtilisateur']; ?></li>
    </ul>
    <a href="../index.php">Retour à l'accueil</a>

    <?php
        // Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté
        if (!isset($_SESSION['pseudo'])) {
        ?>
            <li><a href="pages/connexion.php">Se connecter</a></li>
            <li><a href="pages/inscription.php">Créer un compte</a></li>
        <?php
        }

        if (isset($_SESSION['pseudo'])) {
        ?>
            <li><a href="pages/planet.php">Ma Planète</a></li>
            <li><a href="pages/defi.php">Mes défis journaliers</a></li>
            <li><a href="pages/recyclage.php">Carte des poubelles</a></li>
            <li><a href="pages/compte.php">Mon compte</a></li>
            <li><a href="form/deconnexion.php">Se déconnecter</a></li>
    </ul>
<?php
        }

?>
</body>
</html>
