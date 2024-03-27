<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit("Vous n'êtes pas connecté.");
}

$userId = $_SESSION['user_id'];

$qrData = "http://localhost/sae401402/earthly/pages/compte.php?id=$userId"; // Lien vers le profil de l'utilisateur (ajustez selon vos besoins)

try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $db->prepare("UPDATE utilisateurs SET exp_Utilisateur = exp_Utilisateur + 10 WHERE id = ?");
    $query->execute([$userId]);

    echo $qrData;
} catch (PDOException $erreur) {
    http_response_code(500);
    exit("Erreur de mise à jour de la base de données : ". $erreur->getMessage());
}
?>