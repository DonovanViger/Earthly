<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if(!isset($_SESSION['user_id'])) {
    // Retournez une erreur si l'utilisateur n'est pas connecté
    http_response_code(403);
    exit("Vous n'êtes pas connecté.");
}

// Obtenez l'identifiant de l'utilisateur connecté
$userId = $_SESSION['user_id'];

// Générez le QR code
$qrData = "http://localhost/sae401402/earthly/pages/compte.php?id=$userId"; // Lien vers le profil de l'utilisateur (ajustez selon vos besoins)

// Mettez à jour la base de données
try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mettez à jour la colonne exp_Utilisateur pour ajouter 10 points
    $query = $db->prepare("UPDATE utilisateurs SET exp_Utilisateur = exp_Utilisateur + 10 WHERE id = ?");
    $query->execute([$userId]);

    // Affichez le QR code ou renvoyez une réponse JSON si nécessaire
    echo $qrData;
} catch (PDOException $erreur) {
    // Retournez une erreur si la mise à jour de la base de données échoue
    http_response_code(500);
    exit("Erreur de mise à jour de la base de données : ". $erreur->getMessage());
}
?>
