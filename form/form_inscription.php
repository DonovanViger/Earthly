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

    // Vérifier si les champs requis sont vides
    if(empty($pseudo) || empty($email) || empty($mdp)) {
        throw new Exception("Veuillez remplir tous les champs.");
    }

    // Hacher le mot de passe
    $motDePasseHache = hash('sha256', $mdp);

    // Define the upload directory
    $uploadDirectory = '../uploads/';

    // Initialize $photoPath to NULL
    $photoPath = null;

    // Check if the cropped photo data is present
    if (isset($_POST['cropped_photo'])) {
        // Generate a unique filename for the cropped photo
        $photoPath = $uploadDirectory . uniqid() . '_cropped.jpg';

        // Decode the base64 encoded image data
        $croppedImageData = base64_decode(str_replace('data:image/jpeg;base64,', '', $_POST['cropped_photo']));

        // Save the cropped image to the desired directory
        if (!file_put_contents($photoPath, $croppedImageData)) {
            throw new Exception("Impossible de sauvegarder l'image recadrée.");
        }
    } elseif (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        // Generate a unique filename to prevent overwriting existing files
        $photoPath = $uploadDirectory . uniqid() . '_' . basename($_FILES['photo']['name']);

        // Move the uploaded file to the desired directory
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
            throw new Exception("Impossible de déplacer le fichier téléchargé.");
        }
    }

    // Préparer et exécuter la requête d'insertion avec le chemin de l'image
    $requete = $db->prepare("INSERT INTO utilisateurs (pseudo, mail, mdp, point_Planete, dateConnexion, dateCreationCompte, exp_Utilisateur, pdp) VALUES (:pseudo, :email, :mdp, 0, :dateCreationCompte, :dateCreationCompte, 0, :photo)");
    $requete->bindParam(':pseudo', $pseudo);
    $requete->bindParam(':email', $email);
    $requete->bindParam(':mdp', $motDePasseHache);
    $requete->bindParam(':dateCreationCompte', $dateCreationCompte);
    $requete->bindParam(':photo', $photoPath);
    $requete->execute();

    echo "<p>Compte créé avec succès.</p>";
    echo "<a href='../index.php'>Retour à l'index</a>";

} catch (PDOException $erreur) {
    // En cas d'erreur de connexion à la base de données
    die("Erreur de connexion à la base de données : ". $erreur->getMessage());
} catch (Exception $e) {
    // En cas d'autres erreurs
    echo $e->getMessage();
}
?>
