<?php
session_start(); // Démarre la session (à placer au début de chaque fichier PHP où vous utilisez des sessions)

try {
    // Connexion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des données du formulaire
    $pseudo = $_POST['pseudo'];
    $mdp = hash('sha256', $_POST['mdp']);

    // Requête SQL pour vérifier les informations de connexion
    $requete = $db->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo AND mdp = :mdp");
    $requete->bindParam(':pseudo', $pseudo);
    $requete->bindParam(':mdp', $mdp);
    $requete->execute();

    // Vérification des résultats de la requête
    $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);
    if ($utilisateur) {
        // Crée une variable de session pour l'utilisateur connecté
        $_SESSION['pseudo'] = $pseudo;
        header("Location: ../pages/compte.php"); // Redirige l'utilisateur vers la page d'accueil
        exit();
    } else {
        echo "Identifiant ou mot de passe incorrect.";
        // Redirection vers la page de connexion avec un message d'erreur
    }
} catch (PDOException $erreur) {
    // En cas d'erreur de connexion à la base de données
    die("Erreur de connexion à la base de données : ". $erreur->getMessage());
}
?>