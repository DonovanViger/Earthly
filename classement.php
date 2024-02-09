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
<h2>Classement</h2>
    <table>
      <thead>
        <tr>
          <th scope="col">N°</th>
          <th scope="col">Speudo</th>
          <th scope="col">Points</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($Classements as $classement) { ?>
            <?php
                $i = $i + 1 ?>
          <tr>
            <td><?php echo $i?></td>
            <td><?php echo $classement['pseudo']; ?></td>
            <td><?php echo $classement['point_Utilisateur']; ?></td>

          </tr>
        <?php } ?>
      </tbody>
    </table>


</html>
