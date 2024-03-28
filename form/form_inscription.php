<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/" href="../img2/Fichier 27.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../pages/style.css" />
    <title>Earthly | Erreur de connexion</title>
</head>

<body>

</body>

</html>

<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pseudo = $_POST['pseudo'] ?? '';
    $email = $_POST['email'] ?? '';
    $mdp = $_POST['mdp'] ?? '';
    $dateCreationCompte = date('Y-m-d');

    if(empty($pseudo) || empty($email) || empty($mdp)) {
        throw new Exception("Veuillez remplir tous les champs.");
    }

    $motDePasseHache = hash('sha256', $mdp);

    $uploadDirectory = '../uploads/';

    $photoPath = null;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photoPath = $uploadDirectory . uniqid() . '_' . basename($_FILES['photo']['name']);

        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
            throw new Exception("Impossible de déplacer le fichier téléchargé.");
        }
    }

    $requete = $db->prepare("INSERT INTO utilisateurs (pseudo, mail, mdp, point_Planete, dateConnexion, dateCreationCompte, exp_Utilisateur, pdp) VALUES (:pseudo, :email, :mdp, 0, :dateCreationCompte, :dateCreationCompte, 0, :photo)");
    $requete->bindParam(':pseudo', $pseudo);
    $requete->bindParam(':email', $email);
    $requete->bindParam(':mdp', $motDePasseHache);
    $requete->bindParam(':dateCreationCompte', $dateCreationCompte);
    $requete->bindParam(':photo', $photoPath);
    $requete->execute();

    echo "<div class='erreur_connexion_box'>";
    echo "<p class='erreur_connexion_para'>Compte créé avec succès</p>";
    /* echo "<button class='erreur_button_form'><a href='../pages/connexion.php'>Retour à la page de connexion</a></button>";
    echo "<br>";
    echo "<br>";
    echo "<button class='erreur_button_form'><a href='../index.html'>Retour à la page d'accueil</a></button>"; */
    echo "<br>";
    echo "<br>";
    echo "<form action='form_connexion.php' method='POST'><input type='hidden' name='pseudo' value='".$pseudo."'><input type='hidden' name='mdp' value='".$mdp."'><input type='submit' value='Se connecter' class='erreur_button_form'></form>";
    echo "</div>";

} catch (PDOException $erreur) {
    die("Erreur de connexion à la base de données : ". $erreur->getMessage());
} catch (Exception $e) {
    echo $e->getMessage();
}
?>