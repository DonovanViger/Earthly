<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Mon compte</title>
</head>
<body>
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

    <h1>Recyclez avec nos poubelles intelligentes</h1>
    <h2>Scannez un QR code.</h2>

    <!-- Ajoutez cet élément pour afficher la vidéo de la webcam -->
    <video id="videoElement" autoplay></video>

    <!-- Ajoutez un bouton pour activer/désactiver la caméra -->
    <button id="toggleButton">Activer/Désactiver la caméra</button>

    <?php 
    if (isset($_GET['poubelle'])) {
        $poubelle = $_GET['poubelle'];
        echo "<div>";
        if ($poubelle == 1) {
            echo "<p>Vous recyclez vos déchets cartons, plastiques, papiers et métalliques.</p>";
        } else if ($poubelle == 2) {
            echo "<p>Vous recyclez vos déchets en verre.</p>";
        } else if ($poubelle == 3) {
            echo "<p>Vous jetez vos déchets ordinaires qui ne se recyclent pas.</p>";
        } else {
            echo "<p>Cette poubelle n'existe pas dans notre base de données</p>";
        }
        echo "</div>";
    }
    ?>

    <?php include("../form/templates/footer.php"); ?>

    <script src="jsQR.js"></script>
    <script>
    var videoStream;

    // Fonction pour activer/désactiver la caméra
    function toggleCamera() {
        var video = document.getElementById('videoElement');

        // Si la caméra est déjà active, arrêtez le flux vidéo et définissez la source sur null
        if (videoStream) {
            videoStream.getTracks().forEach(track => track.stop());
            video.srcObject = null;
            videoStream = null;
        } else {
            // Sinon, activez la caméra
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                    videoStream = stream;
                })
                .catch(function(err) {
                    console.log("Erreur lors de l'accès à la webcam: " + err);
                });
        }
    }

    // Associez la fonction toggleCamera au clic sur le bouton
    document.getElementById('toggleButton').addEventListener('click', toggleCamera);
    </script>
</body>
</html>
