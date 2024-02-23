<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['pseudo'])) {
    // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

// Vérifie si un fichier a été téléversé
if (isset($_FILES['nouvelle_image'])) {
    $uploadDirectory = '../uploads/';

    // Récupère le chemin de l'image actuelle de l'utilisateur
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pseudo = $_SESSION['pseudo'];
    $requete = $db->prepare("SELECT pdp FROM utilisateurs WHERE pseudo = :pseudo");
    $requete->bindParam(':pseudo', $pseudo);
    $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);
    $ancienneImage = $resultat['pdp'];

    // Supprime l'ancienne image du dossier uploads
    if ($ancienneImage !== '../uploads/default.jpg') {
        unlink($ancienneImage);
    }

    // Téléverse la nouvelle image dans le dossier uploads
    $nouveauNomImage = $uploadDirectory . uniqid() . '_' . basename($_FILES['nouvelle_image']['name']);
    if (move_uploaded_file($_FILES['nouvelle_image']['tmp_name'], $nouveauNomImage)) {
        // Met à jour le chemin de l'image de profil dans la base de données
        $requete = $db->prepare("UPDATE utilisateurs SET pdp = :nouveauNomImage WHERE pseudo = :pseudo");
        $requete->bindParam(':nouveauNomImage', $nouveauNomImage);
        $requete->bindParam(':pseudo', $pseudo);
        $requete->execute();
        echo "L'image de profil a été mise à jour avec succès.";
    } else {
        echo "Erreur lors du téléversement de l'image.";
    }
} else {
    echo "Aucune image n'a été téléversée.";
}
?>
