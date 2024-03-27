<?php
session_start(); // Démarre la session (à placer au début de chaque fichier PHP où vous utilisez des sessions)

try {
    // Connexion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération du pseudo de l'utilisateur connecté
    $pseudo = $_SESSION['pseudo'];

    // Récupération du nouveau pseudo depuis le formulaire
    $nouveauPseudo = $_POST['newPseudo'];

    // Vérification si le pseudo a été modifié
    if ($nouveauPseudo != $pseudo) {
        // Préparation de la requête avec des paramètres liés
        $requetePseudo = $db->prepare("UPDATE utilisateurs SET pseudo = :nouveauPseudo WHERE pseudo = :pseudo");
        // Liaison des paramètres
        $requetePseudo->bindParam(':nouveauPseudo', $nouveauPseudo);
        $requetePseudo->bindParam(':pseudo', $pseudo);
        // Exécution de la requête
        $requetePseudo->execute();

        // Mise à jour de la variable de session avec le nouveau pseudo
        $_SESSION['pseudo'] = $nouveauPseudo;
    }

    // Redirection vers la page "compte.php"
    header("Location: ../pages/compte.php");
    exit();

} catch (PDOException $erreur) {
    // En cas d'erreur de connexion à la base de données
    die("Erreur de connexion à la base de données : " . $erreur->getMessage());
}
?>
