<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erreur) {
    die("Erreur de connexion à la base de données : " . $erreur->getMessage());
}

$requeteClassement = $db->prepare("SELECT `pseudo`,`point_Utilisateur` FROM `utilisateurs` ORDER BY `point_Utilisateur` DESC LIMIT 10;");
$requeteClassement->execute();
$Classements = $requeteClassement->fetchAll(PDO::FETCH_ASSOC);
$i = 0;
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
            $i = $i + 1 
            ?>
            <tr>
                <td>
                    <?php echo $i ?>
                </td>
                <td>
                    <?php echo $classement['pseudo']; ?>
                </td>
                <td>
                    <?php echo $classement['point_Utilisateur']; ?>
                </td>

            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
        // Affiche les liens "Se connecter" et "Créer un compte" seulement si l'utilisateur n'est pas connecté

        if (isset($_SESSION['pseudo'])) {
        ?>
            <li><a href="planet.php">Ma Planète</a></li>
            <li><a href="defi.php">Mes défis journaliers</a></li>
            <li><a href="recyclage.php">Carte des poubelles</a></li>
            <li><a href="compte.php">Mon compte</a></li>
    </ul>
<?php
        }

?>
</body>
</html>