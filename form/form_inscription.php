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
        $photoTmpPath = $_FILES['photo']['tmp_name'];
        $photoExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

        // Convertir l'image en WebP
        $image = imagecreatefromstring(file_get_contents($photoTmpPath));
        $webpPath = $uploadDirectory . uniqid() . '.webp';
        imagewebp($image, $webpPath, 80); // 80 est le taux de compression, réglez-le selon vos besoins
        imagedestroy($image);

        $photoPath = $webpPath;
    }

    $requete = $db->prepare("INSERT INTO utilisateurs (pseudo, mail, mdp, point_Planete, dateConnexion, dateCreationCompte, exp_Utilisateur, pdp) VALUES (:pseudo, :email, :mdp, 0, :dateCreationCompte, :dateCreationCompte, 0, :photo)");
    $requete->bindParam(':pseudo', $pseudo);
    $requete->bindParam(':email', $email);
    $requete->bindParam(':mdp', $motDePasseHache);
    $requete->bindParam(':dateCreationCompte', $dateCreationCompte);
    $requete->bindParam(':photo', $photoPath);
    $requete->execute();

    echo "<div id='erreur_connexion_box'>";
    echo "<p id='erreur_connexion_para'>Compte créé avec succès</p>";
    echo "<button id='erreur_button_form'><a href='../pages/connexion.php'>Retour à la page de connexion</a>";
    echo "</div>";

} catch (PDOException $erreur) {
    die("Erreur de connexion à la base de données : ". $erreur->getMessage());
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
