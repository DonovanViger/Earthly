<?php
session_start(); // Démarre la session

try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erreur) {
    die("Erreur de connexion à la base de données : " . $erreur->getMessage());
}

$requeteClassement = $db->prepare("SELECT `pseudo`,`expPlaneteUtilisateur`,`point_Utilisateur`, IFNULL(`pdp`, '../uploads/default.jpg') AS `pdp` FROM `utilisateurs` ORDER BY `point_Utilisateur` DESC LIMIT 10;");
$requeteClassement->execute();
$Classements = $requeteClassement->fetchAll(PDO::FETCH_ASSOC);
$i = 0;
?>


<h1 id="h1_classement"><a href="../index.php">Earthly</a></h1>