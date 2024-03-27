<?php
session_start();

try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pseudo = $_SESSION['pseudo'];
    $user_id = $_SESSION['user_id'];

    $nouveauPseudo = htmlspecialchars($_POST['newPseudo']); // Échapper les caractères spéciaux

    if ($nouveauPseudo != $pseudo) {
        $requetePseudo = $db->prepare("UPDATE utilisateurs SET pseudo = :nouveauPseudo WHERE ID_Utilisateur = :user_id");
        $requetePseudo->bindParam(':nouveauPseudo', $nouveauPseudo);
        $requetePseudo->bindParam(':user_id', $user_id);
        $requetePseudo->execute();

        $_SESSION['pseudo'] = $nouveauPseudo;
    }

    header("Location: ../pages/compte.php");
    exit();

} catch (PDOException $erreur) {
    die("Erreur de connexion à la base de données : " . $erreur->getMessage());
}
?>
