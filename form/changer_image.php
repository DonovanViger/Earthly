<?php
session_start();

if (!isset($_SESSION['pseudo'])) {
    header("Location: connexion.php");
    exit();
}

if (isset($_FILES['nouvelle_image'])) {
    $uploadDirectory = '../uploads/';

    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $user_id = $_SESSION['user_id'];
    $requete = $db->prepare("SELECT pdp FROM utilisateurs WHERE ID_Utilisateur = :id");
    $requete->bindParam(':id', $user_id);
    $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);
    $ancienneImage = $resultat['pdp'];

    if ($ancienneImage !== '../uploads/default.jpg') {
        unlink($ancienneImage);
    }

    $nouveauNomImage = $uploadDirectory . uniqid() . '_' . basename($_FILES['nouvelle_image']['name']);
    if (move_uploaded_file($_FILES['nouvelle_image']['tmp_name'], $nouveauNomImage)) {
        $requete = $db->prepare("UPDATE utilisateurs SET pdp = :nouveauNomImage WHERE ID_Utilisateur = :id");
        $requete->bindParam(':nouveauNomImage', $nouveauNomImage);
        $requete->bindParam(':id', $user_id);
        $requete->execute();
        echo "L'image de profil a été mise à jour avec succès.";
        header("Location: ../pages/compte.php");
        exit();
    } else {
        echo "Erreur lors du téléversement de l'image.";
        error_log("Erreur lors du téléversement de l'image: " . $_FILES['nouvelle_image']['error']);
        echo "<button onclick='retour()'>Retour</button>";
    }
} else {
    echo "Aucune image n'a été téléversée.";
    echo "<button onclick='retour()'>Retour</button>";
}

echo '<script> function retour(){ window.location.href = "../pages/compte.php"; }</script>';
?>
