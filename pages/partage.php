<?php

session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if(!isset($_SESSION['pseudo'])) {
    // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erreur) {
    die("Erreur de connexion à la base de données : ". $erreur->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <base href="http://localhost/earthly/pages/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Earthly | Partage</title>
</head>
<body>
    
<?php
if (isset($_GET['pseudo'])) {
    $pseudo = $_GET['pseudo'];
        $query = $db->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo");
        $query->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $query->execute();
        $personne = $query->fetch(PDO::FETCH_ASSOC);
        $profileImage = $personne['pdp'] ? $personne['pdp'] : '../uploads/default.jpg';
        echo "<div id='image_compte'>
        <img src='<?php echo $profileImage; ?>' alt='Image de profil' class='profile-image'>
    </div>
    <div id='texte_compte'>
        <h3>".$personne['pseudo']."</h3>
        <p>Vos informations :</p>
        <ul>
            <li>Pseudo : ".$personne['pseudo']."</li>
            <li>Email : ".$personne['mail']."</li>
            <li>Date de création du compte :
                ".date('j F Y', strtotime($personne['dateCreationCompte']))."
            </li>
            <li>Points : ".$personne['point_Utilisateur']."</li>
            <li>Niveau d\'expérience sur la planète : ".$personne['expPlaneteUtilisateur']."</li>
        </ul>
    </div>";

    } else {
        echo "<p>Aucun compte ne vous a été partagé.</p>";
    }

?>

<?php
        include("../form/templates/footer.php")
    ?>

</body>
</html>