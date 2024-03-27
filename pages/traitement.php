
<?php
session_start();
$iduser = $_SESSION['user_id'];
$date_actuelle = date("Y-m-d");

$insert_into_poubelle = $db->prepare("INSERT INTO scanpoubelle (ID_Utilisateur, ID_Poubelle, dateScan) VALUES (:iduser, 2, :dateActuel)");
$insert_into_poubelle->bindParam(':iduser', $iduser);
$insert_into_poubelle->bindParam(':dateActuel', $date_actuelle);
$insert_into_poubelle->execute();
$update_score = $db->prepare("UPDATE utilisateurs SET point_Planete = point_Planete + 200, exp_Utilisateur = exp_Utilisateur + 200 WHERE ID_Utilisateur = :id_utilisateur");
$update_score->bindParam(':id_utilisateur', $iduser);
$update_score->execute();
?>