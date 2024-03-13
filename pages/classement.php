<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Classement</title>
</head>
<body>
    
<?php
session_start(); // Démarre la session

try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erreur) {
    die("Erreur de connexion à la base de données : " . $erreur->getMessage());
}

$requeteClassement = $db->prepare("SELECT `pseudo`,`point_Utilisateur`, IFNULL(`pdp`, '../uploads/default.jpg') AS `pdp` FROM `utilisateurs` ORDER BY `point_Utilisateur` DESC LIMIT 10;");
$requeteClassement->execute();
$Classements = $requeteClassement->fetchAll(PDO::FETCH_ASSOC);
$i = 0;
?>


<h1 id="h1_classement"><a href="../index.php">Earthly</a></h1>
<h2 id="h2_classement">Classement</h2>

<table id="table_classement" class="table table-hover table-sm w-50 mx-auto">
  <thead>
    <tr>
      <th scope="col" class="text-center align-middle">#</th>
      <th scope="col" class="text-center align-middle">Avatar</th>
      <th scope="col" class="text-center align-middle">Pseudo</th>
      <th scope="col" class="text-center align-middle">XP</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">
    <?php $i = 0; foreach ($Classements as $classement) { $i++; ?>
      <tr>
        <th scope="row" class="text-center align-middle"><?php echo $i; ?></th>
        <td class="text-center align-middle"><img src="<?php echo $classement['pdp']; ?>" alt="Avatar de <?php echo $classement['pseudo']; ?>" class="avatar"></td>
        <td class="text-center align-middle"><?php echo $classement['pseudo']; ?></td>
        <td class="text-center align-middle"><?php echo $classement['point_Utilisateur']; ?> XP</td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<?php
        // Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté

        if (isset($_SESSION['pseudo'])) {
        ?>
        <footer>
        <ul class="footer-nav">
            <li><a href="planet.php">Ma Planète</a></li>
            <li><a href="defi.php">Mes défis journaliers</a></li>
            <li><a href="recyclage.php">Carte des poubelles</a></li>
            <li><a href="compte.php">Mon compte</a></li>
            <li><a href="classement.php">Classement</a></li>
        </ul>
        </footer>
<?php
        }

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>