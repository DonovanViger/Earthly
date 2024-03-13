<?php
session_start(); // Démarre la session (à placer au début de chaque fichier PHP où vous utilisez des sessions)

try {
    // Connexion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération du pseudo de l'utilisateur connecté
    $pseudo = $_SESSION['pseudo'];

    // Récupération des données du formulaire
    $nouveauPseudo = $_POST['nouveauPseudo'];
    $nouvelleEmail = $_POST['nouvelleEmail'];

    // Vérification si le pseudo a été modifié
    if ($nouveauPseudo != $pseudo) {
        // Mise à jour du pseudo dans la base de données
        $requetePseudo = $db->prepare("UPDATE utilisateurs SET pseudo = :nouveauPseudo WHERE pseudo = :pseudo");
        $requetePseudo->bindParam(':nouveauPseudo', $nouveauPseudo);
        $requetePseudo->bindParam(':pseudo', $pseudo);
        $requetePseudo->execute();

        // Mise à jour de la variable de session avec le nouveau pseudo
        $_SESSION['pseudo'] = $nouveauPseudo;
    }

    // Vérification si l'adresse e-mail a été modifiée
    if ($nouvelleEmail != $_SESSION['mail']) {
        // Mise à jour de l'adresse e-mail dans la base de données
        $requeteEmail = $db->prepare("UPDATE utilisateurs SET mail = :nouvelleEmail WHERE pseudo = :pseudo");
        $requeteEmail->bindParam(':nouvelleEmail', $nouvelleEmail);
        $requeteEmail->bindParam(':pseudo', $pseudo);
        $requeteEmail->execute();

        // Mise à jour de la variable de session avec la nouvelle adresse e-mail
        $_SESSION['mail'] = $nouvelleEmail;
    }

    header("Location: ../pages/compte.php"); // Redirige l'utilisateur vers la page d'accueil
    exit();

} catch (PDOException $erreur) {
    // En cas d'erreur de connexion à la base de données
    die("Erreur de connexion à la base de données : ". $erreur->getMessage());
}
?>
