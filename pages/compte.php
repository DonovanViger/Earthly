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
    <p>Bienvenue, <?php echo $utilisateur['pseudo']; ?>!</p>
    <p>Vos informations :</p>
    <ul>
        <li>Pseudo : <?php echo $utilisateur['pseudo']; ?></li>
        <li>Email : <?php echo $utilisateur['mail']; ?></li>
    </ul>
    <a href="../index.php">Retour à l'accueil</a>
</body>
</html>
