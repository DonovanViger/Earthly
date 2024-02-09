<?php
try {
    // Connexion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des données du formulaire
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $dateCreationCompte = date('Y-m-d');

    // Hacher le mot de passe
    $motDePasseHache = hash('sha256', $mdp);

    // Préparer et exécuter la requête d'insertion
    $requete = $db->prepare("INSERT INTO utilisateurs (pseudo, mail, mdp, point_Utilisateur, dateConnexion, dateCreationCompte, expPlaneteUtilisateur) VALUES (:pseudo, :email, :mdp, 0, :dateCreationCompte, :dateCreationCompte, 0)");
    $requete->bindParam(':pseudo', $pseudo);
    $requete->bindParam(':email', $email);
    $requete->bindParam(':mdp', $motDePasseHache);
    $requete->bindParam(':dateCreationCompte', $dateCreationCompte);
    $requete->execute();

    echo "Compte créé avec succès.";
} catch (PDOException $erreur) {
    // En cas d'erreur de connexion à la base de données
    die("Erreur de connexion à la base de données : ". $erreur->getMessage());
}
?>
