<?php
session_start();

try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pseudo = $_SESSION['pseudo'];
    $user_id = $_SESSION['user_id'];

    $nouveauPseudo = htmlspecialchars($_POST['newPseudo']);

    if ($nouveauPseudo != $pseudo) {
        $requeteVerifPseudo = $db->prepare("SELECT COUNT(*) AS count FROM utilisateurs WHERE pseudo = :nouveauPseudo AND ID_Utilisateur != :user_id");
        $requeteVerifPseudo->bindParam(':nouveauPseudo', $nouveauPseudo);
        $requeteVerifPseudo->bindParam(':user_id', $user_id);
        $requeteVerifPseudo->execute();
        $resultatVerifPseudo = $requeteVerifPseudo->fetch(PDO::FETCH_ASSOC);
        if ($resultatVerifPseudo['count'] > 0) {
            echo "<script>alert('Ce pseudo est déjà pris. Veuillez en choisir un autre.');</script>";
            echo "<script>window.location = '../pages/compte.php';</script>";
            exit;
        }

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
