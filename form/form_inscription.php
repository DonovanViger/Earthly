<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../pages/style.css" />
    <title>Earthly | Erreur d'inscription</title>
</head>
<body>
    
</body>
</html>

<?php
try {
    // Connexion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des données du formulaire
    $pseudo = $_POST['pseudo'] ?? '';
    $email = $_POST['email'] ?? '';
    $mdp = $_POST['mdp'] ?? '';
    $dateCreationCompte = date('Y-m-d');

    // Vérifier si tous les champs sont remplis
    if (empty($pseudo) || empty($email) || empty($mdp)) {
        throw new Exception("Veuillez remplir tous les champs.");
    }

    // Vérifier l'unicité du pseudo
    $requeteVerifPseudo = $db->prepare("SELECT COUNT(*) AS count FROM utilisateurs WHERE pseudo = :pseudo");
    $requeteVerifPseudo->bindParam(':pseudo', $pseudo);
    $requeteVerifPseudo->execute();
    $resultatVerifPseudo = $requeteVerifPseudo->fetch(PDO::FETCH_ASSOC);
    if ($resultatVerifPseudo['count'] > 0) {
        echo "<script>alert('Ce pseudo est déjà pris. Veuillez en choisir un autre.');</script>";
        echo "<script>window.location = '../pages/inscription.php';</script>";
        exit; // Arrêter l'exécution du script après l'affichage de l'alerte
    }

    // Hasher le mot de passe
    $motDePasseHache = hash('sha256', $mdp);

    // Code pour le traitement de l'upload de l'image (non modifié)
    $uploadDirectory = '../uploads/';

    $photoPath = null;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photoTmpPath = $_FILES['photo']['tmp_name'];
        $photoExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

        // Convertir l'image en WebP
        $image = imagecreatefromstring(file_get_contents($photoTmpPath));
        $webpPath = $uploadDirectory . uniqid() . '.webp';
        imagewebp($image, $webpPath, 80); // 80 est le taux de compression, réglez-le selon vos besoins
        imagedestroy($image);

        $photoPath = $webpPath;
    }

    // Insertion dans la base de données
    $requeteInsertion = $db->prepare("INSERT INTO utilisateurs (pseudo, mail, mdp, point_Planete, dateConnexion, dateCreationCompte, exp_Utilisateur, pdp) VALUES (:pseudo, :email, :mdp, 0, :dateCreationCompte, :dateCreationCompte, 0, :photo)");
    $requeteInsertion->bindParam(':pseudo', $pseudo);
    $requeteInsertion->bindParam(':email', $email);
    $requeteInsertion->bindParam(':mdp', $motDePasseHache);
    $requeteInsertion->bindParam(':dateCreationCompte', $dateCreationCompte);
    $requeteInsertion->bindParam(':photo', $photoPath);
    $requeteInsertion->execute();

    // Affichage du message de succès
    echo "<div id='erreur_connexion_box'>";
    echo "<p id='erreur_connexion_para'>Compte créé avec succès</p>";
    echo "<button id='erreur_button_form'><a href='../pages/connexion.php'>Retour à la page de connexion</a>";
    echo "</div>";

} catch (PDOException $erreur) {
    // Gestion des erreurs PDO
    die("Erreur de connexion à la base de données : " . $erreur->getMessage());
} catch (Exception $e) {
    // Gestion des autres exceptions
    echo $e->getMessage();
}
?>
