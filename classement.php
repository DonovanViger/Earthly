<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erreur) {
    die("Erreur de connexion à la base de données : ". $erreur->getMessage());
}

$requeteClassement = $db->prepare("SELECT `pseudo`,`point_Utilisateur` FROM `utilisateurs` ORDER BY `point_Utilisateur` DESC LIMIT 10;");
$requeteClassement->execute();
$Classements = $requeteClassement->fetchAll(PDO::FETCH_ASSOC);
?>

<html>
<h2>Mes demandes en cours de traitement</h2>
    <table>
      <thead>
        <tr>
          <th scope="col">Date de création</th>
          <th scope="col">Titre</th>
          <th scope="col">Tag</th>
          <th scope="col">Description</th>
          <th scope="col">Avancement</th>
          <th scope="col">Statut</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($Classements as $classement) { ?>
          <tr>
            <td><?php echo $classement['pseudo']; ?></td>
            <td><?php echo $demande['point_Utilisateur']; ?></td>

          </tr>
        <?php } ?>
      </tbody>
    </table>


</html>
