<?php
try {
    // Connexion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des données du formulaire
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];

    // Récupérer le mot de passe haché correspondant au pseudo depuis la base de données
    $requete = $db->prepare("SELECT mdp FROM utilisateurs WHERE pseudo = :pseudo");
    $requete->bindParam(':pseudo', $pseudo);
    $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le pseudo existe dans la base de données
    if ($resultat) {
        // Comparer le mot de passe saisi par l'utilisateur avec le mot de passe haché stocké
        if (password_verify($mdp, $resultat['mdp'])) {
            // Le mot de passe est correct
            echo "Connexion réussie. Bienvenue, " . $pseudo . "!";
        } else {
            // Le mot de passe est incorrect
            echo "Identifiant ou mot de passe incorrect.";
        }
    } else {
        // Le pseudo n'existe pas dans la base de données
        echo "Identifiant ou mot de passe incorrect.";
    }
} catch (PDOException $erreur) {
    // En cas d'erreur de connexion à la base de données
    die("Erreur de connexion à la base de données : ". $erreur->getMessage());
}
?>
