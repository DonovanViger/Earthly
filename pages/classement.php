<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Classement</title>
    <style>
    #table_classement {
        border-collapse: separate;
        /* Sépare les bordures des cellules */
        border-spacing: 2px;
        /* Ajoute de l'espace entre les cellules */
        margin-top: 3%;
        margin-bottom: 10%;
    }

    table{
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }

    #table_classement th,
    #table_classement td {
        padding: 1.5%;
        /* Ajoute un rembourrage autour du contenu de la cellule */
    }

    .petit{
        width: 12%;
    }
    </style>
</head>

<body>

    <?php include("../form/templates/header.php") ?>

    <h2 id="h2_classement">Classement</h2>

    <table id="table_classement" class="table-hover w-75 mx-auto">
  <thead>
    <tr>
      <th scope="col" class="text-center align-middle petit">#</th>
      <th scope="col" class="text-center align-middle petit">Avatar</th>
      <th scope="col" class="px-5 align-middle">Pseudo</th>
      <th scope="col" class="text-center align-middle petit">Points</th>
      <th scope="col" class="text-center align-middle petit">XP Planète</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">
    <?php $i = 0; foreach ($Classements as $classement) { $i++; ?>
    <tr>
      <th scope="row" class="text-center align-middle"><?php echo $i; ?></th>
      <td class="text-center align-middle"><img src="<?php echo $classement['pdp']; ?>" alt="Avatar de <?php echo $classement['pseudo']; ?>" class="avatar"></td>
      <td class="px-5 align-middle"><?php echo $classement['pseudo']; ?></td>
      <td class="text-center align-middle"><?php echo $classement['point_Utilisateur']; ?></td>
      <td class="text-center align-middle"><?php echo $classement['expPlaneteUtilisateur']; ?> XP</td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>